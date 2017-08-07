<?php
/**
 * Robot site provider
 * @package robot
 * @version 0.0.1
 * @upgrade true
 */

namespace Robot\Controller;

class MainController extends \SiteController
{

    public function feedAction(){
        $handlers = $this->config->robot['feed'] ?? [];
        $pages = [];
        
        foreach($handlers as $module => $handler){
            $hans   = explode('::', $handler);
            $class  = $hans[0];
            $method = $hans[1];
            
            $hand_class = $class::$method();
            if($hand_class)
                $pages = array_merge($pages, $hand_class);
        }
        
        $dis = &\Phun::$dispatcher;
        
        $config_name = hs($dis->config->name);
        
        $feed = (object)[
            'url'         => $dis->router->to('robotFeed'),
            'description' => $config_name . ' RSS Feed',
            'updated'     => null,
            'host'        => $dis->router->to('siteHome'),
            'title'       => $config_name
        ];
        
        if(module_exists('site-param')){
            if($dis->setting->frontpage_description)
                $feed->description = hs($dis->setting->frontpage_description);
            if($dis->setting->frontpage_title)
                $feed->title = hs($dis->setting->frontpage_title);
        }
        
        $this->robot->feed($feed, $pages);
    }
    
    public function sitemapAction(){
        $handlers = $this->config->robot['sitemap'] ?? [];
        $pages = [];
        
        foreach($handlers as $module => $handler){
            $hans   = explode('::', $handler);
            $class  = $hans[0];
            $method = $hans[1];
            
            $hand_class = $class::$method();
            if($hand_class)
                $pages = array_merge($pages, $hand_class);
        }
        
        $this->robot->sitemap($pages);
    }
}