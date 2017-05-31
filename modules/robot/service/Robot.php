<?php
/**
 * robot service
 * @package robot
 * @version 0.0.1
 * @upgrade true
 */

namespace Robot\Service;

class Robot {
    
    public function sitemap($pages, $type='xml'){
        $last_update = 0;
        $has_image = false;
        foreach($pages as $page){
            $lastmod = strtotime($page->lastmod);
            if($lastmod > $last_update)
                $last_update = $lastmod;
            if(isset($page->image))
                $has_image = true;
        }
        
        $dis = \Phun::$dispatcher;
        
        if($type == 'xml'){
            $dis->res->addHeader('Content-Type', 'application/xml; charset=UTF-8');
            $dis->res->render('robot', 'sitemap', ['pages'=>$pages, 'has_image'=>$has_image]);
        }elseif($type == 'json'){
            $dis->res->addContent(json_encode($pages));
            $dis->res->addHeader('Content-Type', 'application/json; charset=UTF-8');
        }
        
        $cache = $dis->config->robot['cache'];
        if($cache)
            $dis->res->cache($cache);
        
        $dis->res->addHeader('Last-Modified', gmdate('D, d M Y H:i:s', $last_update) . ' GMT');
        $dis->res->send();
    }
    
    public function feed($feed, $pages, $type='xml'){
        $last_update = 0;
        foreach($pages as $page){
            $updated = strtotime($page->updated);
            if($updated > $last_update)
                $last_update = $updated;
        }
        
        $dis = \Phun::$dispatcher;
        
        if(!$feed->updated)
            $feed->updated = date('c', $last_update);
        
        if($type === 'xml'){
            $dis->res->addHeader('Content-Type', 'application/xml; charset=UTF-8');
            $dis->res->render('robot', 'feed', ['pages'=>$pages, 'feed'=>$feed]);
        }elseif($type === 'json'){
            $dis->res->addContent(json_encode($pages));
            $dis->res->addHeader('Content-Type', 'application/json; charset=UTF-8');
        }
        
        $cache = $dis->config->robot['cache'];
        if($cache)
            $dis->res->cache($cache);
        
        $dis->res->addHeader('Last-Modified', gmdate('D, d M Y H:i:s', $last_update) . ' GMT');
        $dis->res->send();
    }
}