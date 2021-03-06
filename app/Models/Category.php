<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function subcategories()
    {
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section','section_id')->select('id', 'name');
    }

    public function parentcategory()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id')->select('id','category_name');
    }

    public static function categoryDetails($url)
    {
        $categoryDetails = Category::select('id','parent_id','section_id','category_name','url','description')->with(['subcategories'=>function($query){
            $query->select('id','parent_id','section_id','category_name','url','description')->where('status',1);
        }])->where('url',$url)->first()->toArray();
        if ($categoryDetails['parent_id']==0) {
            $breadcrumbs = '<a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }else{
            $parentCategory = Category::select('category_name','url')->where('id',$categoryDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<a href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a>&nbsp;<span class="divider"></span>&nbsp;<a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }
        $catIds = array();
        $catSections = array();
        $catIds[] = $categoryDetails['id'];
        $catSections[] = $categoryDetails['section_id'];
        foreach ($categoryDetails['subcategories'] as $key => $subcat) {
            $catIds[] = $subcat['id'];
            $catSections[] = $subcat['section_id'];
        }

        return array('catIds'=>$catIds,'catSections'=>$catSections,'categoryDetails'=>$categoryDetails,'breadcrumbs'=>$breadcrumbs);
    }
}
