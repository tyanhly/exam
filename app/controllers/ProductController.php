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
        
        $keywords = \Input::get('keywords', null);
        
        $validator = Validator::make(
            Input::all(), Config::get('constants.listPageValidator')
        );
        if ($validator->fails()){
//             dd($validator->errors()->first());
            App::abort(404, $validator->errors()->first());
        }
        $query = Product::orderBy($orderBy, $orderValue);
        
//         dd($keywords);
        if($keywords!==null){
            $query->where('id', 'like', "%$keywords%");
            $query->orwhere('name', 'like', "%$keywords%");
            $query->orwhere('code', 'like', "%$keywords%");
            $query->orwhere('sale_price', 'like', "%$keywords%");
        }
        
        $count = $query->count();
        $data = $query->skip($skip)->take($perPage)->get()->toArray();
//         dd($data);
        $products = \Paginator::make($data, $count, $perPage);

        return View::make('product.index',array(
            'products' => $products,
            'keywords' => $keywords,
            'perPageForm' => $perPageForm,
            'orderBy' => $orderBy,
            'orderValue' => $orderValue
        ));
    }


    /**
     * Display the specified resource.
     *
     * @param int $id            
     * @return Response
     */
    public function detail($id)
    {
        // get the nerd
        $product = Product::find($id);
        
        // show the view and pass the nerd to it
        return View::make('product.show')->with('product', $nerd);
    }
n
}