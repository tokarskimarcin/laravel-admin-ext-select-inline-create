<?php


namespace Encore\SelectInlineCreate\Form;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class SelectResponse
{
    /**
     * Get proper response for SelectInlineCreate field model request
     * @param Model $entity
     * @param \closure $callback
     * @return JsonResponse
     */
    public static function get(Model $entity, \closure $callback)
    {
        $response = [
            'success' => false
        ];
        if($entity){
            $option = $callback($entity);
            if(self::isEmpty($option)){
                $response['message'] = trans('select-inline-create::select.empty_option');
            }else{
                $response['success'] = true;
                $response['option'] = $option;
            }
        }else{
            $response['message'] = trans('select-inline-create::select.entity_not_found');
        }
        return JsonResponse::create($response);
    }

    protected static function isEmpty($option){
        return !isset($option['id'], $option['text']) || empty($option['id']) || empty($option['text']);
    }
}
