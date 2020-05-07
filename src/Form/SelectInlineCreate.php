<?php


namespace Encore\SelectInlineCreate\Form;


use Encore\Admin\Facades\Admin;
use Encore\Admin\Form\Field\Select;
use Encore\ModalForm\Form\ModalButton;
use Encore\SelectInlineCreate\Exceptions\ParameterMissingException;
use Illuminate\Database\Eloquent\Model;

class SelectInlineCreate extends Select
{
    protected $view = 'select-inline-create::select';

    /**
     * @var string
     */
    private $createUrl;

    /**
     * @var string
     */
    protected $searchUrl = null;

    public function __construct($column = '', $arguments = [])
    {
        parent::__construct($column, $arguments);
        $this->createRoute(url()->current());
    }

    public function createRoute(string $createRoute)
    {
        $this->createUrl = $createRoute;
        return $this;
    }

    /**
     * Load options from ajax results.
     *
     * @param string $url
     * @param string $idField
     * @param string $textField
     * @return SelectInlineCreate
     */
    public function ajax($url, $idField = 'id', $textField = 'text')
    {
        $this->setSearchUrl($url);
        return parent::ajax($url, $idField, $textField);
    }

    /**
     * Sets only ajax url for pulling model information purpose.
     * @param string $url
     * @return $this
     */
    public function setSearchUrl(string $url)
    {
        $this->searchUrl = $url;
        return $this;
    }

    public function render()
    {
        if (empty($this->searchUrl)) {
            throw new ParameterMissingException(sprintf('`%s` missing from %s field. Use "setSearchUrl" or "ajax" method.',
                'searchUrl', self::class));
        }

        Admin::script(file_get_contents(public_path('/vendor/laravel-admin-ext/select-inline-create/js/select.js')));
        Admin::style(file_get_contents(public_path('/vendor/laravel-admin-ext/select-inline-create/css/select.css')));
        $modalButton = new ModalButton('+', $this->createUrl);
        $modalButton->setClass('btn btn-success select-inline-button');
        $this->addVariables([
            'modalButton' => $modalButton->render()
        ]);

        $this->attribute('data-model-search-url', $this->searchUrl);

        return parent::render();
    }

    /**
     * @param Model $entity
     * @param \closure $callback
     */
    public static function response(Model $entity, \closure $callback){
        return SelectResponse::get($entity, $callback);
    }
}
