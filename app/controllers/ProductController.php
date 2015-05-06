<?php

class ProductController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // get request data
        $page = \Input::get('page', 1);
        $perPage = \Input::get('perPage', Config::get('constants.perPage'));
        $skip = ($page - 1) * $perPage;
        
        $orderBy = \Input::get('orderBy', 'id');
        $orderValue = \Input::get('orderValue', 'DESC');
        
        $perPageForm["perPageList"] = Config::get('constants.perPageList');
        $perPageForm["defaultPerPage"] = $perPage;
        
        $validator = Validator::make(
            Input::all(), Config::get('constants.listPageValidator')
        );
        if ($validator->fails()){
            return App::abort(404, $validator->errors()->first());
        }
        $query = Product::orderBy($orderBy, $orderValue);
        
        
        $count = $query->count();
        $data = $query->skip($skip)->take($perPage)->get()->toArray();
//         dd($data);
        $products = \Paginator::make($data, $count, $perPage);

        return View::make('product.index',array(
            'products' => $products,
            'perPageForm' => $perPageForm,
            'orderBy' => $orderBy,
            'orderValue' => $orderValue
        ));
    }

}