<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;
use Illuminate\Http\JsonResponse;
   
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
    
            $data = Category::query();
    
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showcategory"><i class="fa-regular fa-eye"></i> View</a>';
                           $btn = $btn. '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editcategory"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
      
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletecategory"><i class="fa-solid fa-trash"></i> Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
          
        return view('category.index');
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
            
            'name' => 'required',
             
        ]);
          
       $check=Category::where('id',$request->category_id)->first();
       if($check==null){
        Category::insert([
           
            'name' => $request->name, 
           
        ]);  
       }
       else{
        Category::where('id',$request->category_id)->update([
                    
                
                    'name' => $request->name, 
                    
                ]);        
            }
        return response()->json(['success'=>'Category saved successfully.']);
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $Category = Category::find($id);
        return response()->json($Category);
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function edit($id): JsonResponse
    {
        $Category = Category::find($id);
        return response()->json($Category);
    }
      
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        Category::find($id)->delete();
        
        return response()->json(['success'=>'Category deleted successfully.']);
    }
}