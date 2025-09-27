<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Config\Services;

use App\Models\ConfigPage;
use App\Models\Banner;
use App\Models\BannerDetail;
use App\Models\Menu;
use App\Models\Plan;
use App\Models\Product;

class HomePageController extends BaseController
{
    private $m_model;
    private $b_model;
    private $menu;
    private $p_model;
    private $pr_model;
    private $bd_model;

    public function __construct(){
        $this->m_model = new Menu();
        $this->b_model = new Banner();
        $this->p_model = new Plan();
        $this->pr_model = new Product();
        $this->bd_model = new BannerDetail();

        $request = Services::request();
        $url = (string) $request->uri->getSegment(1);
        $this->menu = $this->m_model->where(['url' => $url, 'type_menu' => 'Pagina'])->first();
    }

    public function index()
    {
        $banner = $this->b_model->where(['reference' => $this->menu->id, 'type' => 'banner_home'])->first();
        $how = $this->b_model->where(['reference' => $this->menu->id, 'type' => 'how_works'])->first();
        $events = $this->b_model->where(['type' => 'medios'])->first();
        $banner_product = $this->b_model->where(['type' => 'banner_product'])->first();
        $plans = $this->p_model
            ->select([
                'plans.*',
                'products.name as product_name',
                'products.price as product_price'
            ])
            ->where([
                'plans.status' => 'active',
                'products.status' => 'active'
            ])
            ->join('products', 'products.id = plans.product_id', 'left')
            ->findAll();
        // var_dump($plans); die;

        return view('home_page/home/index', [
            'banner'            => $banner,
            'how'               => $how,
            'events'            => $events,
            'banner_product'    => $banner_product,
            'plans'             => $plans
        ]);
    }

    public function about(){
        $banner = $this->b_model->where(['reference' => $this->menu->id, 'type' => 'banner_about'])->first();
        $events = $this->b_model->where(['type' => 'medios'])->first();
        $detail = $this->b_model->where(['type' => 'detail_about'])->first();
        $why = $this->b_model->where(['type' => 'why'])->first();
        // var_dump([$this->menu, $events]); die;

        return view('home_page/about/index', [
            'banner'    => $banner,
            'detail'    => $detail,
            'why'       => $why,
            'events'    => $events,
        ]);
    }

    public function knowthebusiness(){
        $banner     = $this->b_model->where(['reference' => $this->menu->id, 'type' => 'banner_knowthebusiness'])->first();
        $details    = $this->b_model->where(['reference' => $this->menu->id, 'type' => 'knowthebusiness_details'])->findAll();
        $video      = $this->b_model->where(['reference' => $this->menu->id, 'type' => 'knowthebusiness_video'])->first();
        $files      = $this->b_model->where(['reference' => $this->menu->id, 'type' => 'knowthebusiness_files'])->first();
        $faqs       = $this->b_model->where(['reference' => $this->menu->id, 'type' => 'faq'])->first();
        $faqs->details = array_chunk($faqs->details, 2);

        $banner_product = $this->b_model->where(['type' => 'banner_product'])->first();
        $plans = $this->p_model
            ->select([
                'plans.*',
                'products.name as product_name',
                'products.price as product_price'
            ])
            ->where([
                'plans.status' => 'active',
                'products.status' => 'active'
            ])
            ->join('products', 'products.id = plans.product_id', 'left')
            ->findAll();

        // var_dump($faqs); die;
        return view('home_page/business/index', [
            'banner'    => $banner,
            'details'   => $details,
            'video'     => $video,
            'files'     => $files,
            'faqs'      => $faqs,
            'banner_product'    => $banner_product,
            'plans'             => $plans
        ]);
    }
    
    public function knowthebusiness_simulation(){
        $banner  = $this->b_model->where(['type' => 'banner_simulador'])->first();
        $product = $this->pr_model->where(['status' => 'active'])->first();

        // var_dump($product); die;

        return view('home_page/business/simulation', [
            'banner'    => $banner,
            'product'   => $product
        ]);
    }

    public function blog(){
        $banner = $this->b_model->where(['type' => 'banner_blog'])->first();
        
        $events = $this->b_model->where(['type' => 'medios'])->first();
        return view('home_page/stories/blog', [
            'events'    => $events,
            'banner'    => $banner
        ]);
    }

    public function blog_detail($id){
        $detail = $this->bd_model->find($id);
        $banner = $detail->banner;
        $banner->sub_title = $detail->title;
        $banner->button = $detail->icon;
        $banner->url = $detail->url;

        // var_dump($detail); die;

        return view('home_page/stories/blog_detail', [
            'detail' => $detail,
            'banner'    => $banner
        ]);
    }
    
    public function testimonials(){
        
        $banner = $this->b_model->where(['type' => 'banner_testimony'])->first();
        $banner->title_2 = $banner->title;
        $banner->title = null;
        $events = $this->b_model->where(['type' => 'medios'])->first();
        return view('home_page/stories/testimonials', [
            'events'    => $events,
            'banner'    => $banner,
        ]);
    }

    public function galery(){
        
        $banner = $this->b_model->where(['type' => 'banner_galery'])->first();

        // var_dump($banner); die;
        return view('home_page/stories/galery', [
            'banner'    => $banner                                  
        ]);
    }
}
