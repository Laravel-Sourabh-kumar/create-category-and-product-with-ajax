<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use DataTables;
use Illuminate\Http\JsonResponse;
   
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
    
            $data = Product::query();
    
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showProduct"><i class="fa-regular fa-eye"></i> View</a>';
                           $btn = $btn. '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
      
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i> Delete</a>';
    
                            return $btn;
                    })
                    ->addColumn('cat_id', function($row){
                                $cat_ids=Category::where('id',$row->cat_id)->first();
                                if($cat_ids==null){
                                  $cat_id=null;
                                }
                                else{
                                    $cat_id= $cat_ids->name;
                                }
                              return  $cat_id;
                 })
                    ->rawColumns(['action','cat_id'])
                    ->make(true);
        }
        $category=Category::get();
        return view('product.index',compact('category'));
    }
         
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'cat_id' => 'required',
            'name' => 'required',
            'price' => 'required',
        ]);
          
       $check=Product::where('id',$request->product_id)->first();
       if($check==null){
        Product::insert([
           
            'name' => $request->name, 
            'price' => $request->price,
            'cat_id' => $request->cat_id
        ]);  
       }
       else{
        Product::where('id',$request->product_id)->update([
                    
                
                    'name' => $request->name, 
                    'price' => $request->price,
                    'cat_id' => $request->cat_id
                ]);        
            }
        return response()->json(['success'=>'Product saved successfully.']);
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $product = Product::find($id);
        return response()->json($product);
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id): JsonResponse
    {
        $product = Product::find($id);
        return response()->json($product);
    }
      
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        Product::find($id)->delete();
        
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}