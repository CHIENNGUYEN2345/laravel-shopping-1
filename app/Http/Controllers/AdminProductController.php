<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Components\Recusive;
use Storage;
use App\Product;
use App\Traits\StorageImageTrait;
use App\ProductImage;
use App\Tag;
use App\ProductTag;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductAddRequest;

class AdminProductController extends Controller
{
    use StorageImageTrait;
    private $category;
    private $product;
    private $productImage;
    private $tag;
    private $productTag;
    public function __construct(Category $category,Product $product, ProductImage $productImage,Tag $tag, ProductTag $productTag){
        $this->category = $category;
        $this->product = $product;
        $this->productImage = $productImage;
        $this->tag = $tag;
        $this->productTag = $productTag;
    }
    public function index(){
        $products = $this->product->latest()->paginate(5);
        return view('admin.product.index',compact('products'));
    }
    public function create(){
        $htmlOption = $this->getCategory($parentId = '');
        return view('admin.product.add',compact('htmlOption'));
    }
    public function getCategory($parentId){
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($parentId);
        return $htmlOption;
    }
    public function store(ProductAddRequest $request){
        try{
        DB::beginTransaction();
            //create product data
        $dataProductCreate = [
            'name'=>$request->name,
            'price'=>$request->price,
            'content'=>$request->contents,
            'user_id'=>auth()->id(),
            'category_id'=>$request->category_id
        ];

        //create image info of product
        $dataUploadFeatureImage = $this->storageImageTrait($request, 'feature_image_path', 'product');
        if(!empty($dataUploadFeatureImage)){
            $dataProductCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
            $dataProductCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
        }
        $product = $this->product->create($dataProductCreate);

        //insert data to product_images
        if($request->hasFile('image_path')){
            foreach($request->image_path as $fileItem){
                $dataProductImageDetail = $this->storageImageTraitUploadMutiple($fileItem,'product');
                $product->images()->create([
                    'product_id' => $product->id,
                    'image_path' => $dataProductImageDetail['file_path'],
                    'image_name' => $dataProductImageDetail['file_name']
                ]);
                
            }
        }
        //insert tags to product
        if(!empty($request->tags)){
            foreach($request->tags as $tagItem){
            //insert to tags
            $tagInstance = $this->tag->firstOrCreate(['name' => $tagItem]);
            $tagIds[] = $tagInstance->id;
            }
        }
        
        $product->tags()->attach($tagIds);
        DB::commit();
        return redirect()->route('product.index');
        //giai thich: code chạy từ DB::beginTransaction() -> DB::commit() , nếu có lỗi sẽ rollBack
        }catch(\Exception $exception){
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line: ' . $exception->getLine());
        }

        
    }

    public function edit($id){
        $product = $this->product->find($id);
        $htmlOption = $this->getCategory($product->category_id);
        return view('admin.product.edit',compact('htmlOption','product'));
    }

    public function update(Request $request,$id){
        try{
        DB::beginTransaction();
            //create product data
        $dataProductUpdate = [
            'name'=>$request->name,
            'price'=>$request->price,
            'content'=>$request->contents,
            'user_id'=>auth()->id(),
            'category_id'=>$request->category_id
        ];

        //create image info of product
        $dataUploadFeatureImage = $this->storageImageTrait($request, 'feature_image_path', 'product');
        if(!empty($dataUploadFeatureImage)){
            $dataProductUpdate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
            $dataProductUpdate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
        }

        $this->product->find($id)->update($dataProductUpdate);
        $product = $this->product->find($id);

        //insert data to product_images
        if($request->hasFile('image_path')){
            $this->productImage->where('product_id',$id)->delete();
            foreach($request->image_path as $fileItem){
                $dataProductImageDetail = $this->storageImageTraitUploadMutiple($fileItem,'product');
                $product->images()->create([
                    'product_id' => $product->id,
                    'image_path' => $dataProductImageDetail['file_path'],
                    'image_name' => $dataProductImageDetail['file_name']
                ]);
                
            }
        }
        //insert tags to product
        if(!empty($request->tags)){
            foreach($request->tags as $tagItem){
            //insert to tags
            $tagInstance = $this->tag->firstOrCreate(['name' => $tagItem]);
            $tagIds[] = $tagInstance->id;
            }
        }
        
        $product->tags()->sync($tagIds);
        DB::commit();
        return redirect()->route('product.index');
        //giai thich: code chạy từ DB::beginTransaction() -> DB::commit() , nếu có lỗi sẽ rollBack
        }catch(\Exception $exception){
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line: ' . $exception->getLine());
        }
    }

    public function delete($id){
        try{
            $this->product->find($id)->delete();
            return response()->json([
                'code'=>200,
                'message'=>'success'
            ], 200);
        }catch(\Exception $exception){
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line: ' . $exception->getLine());
            return response()->json([
                'code'=>500,
                'message'=>'fail'
            ], 500);
        }
    }
}
