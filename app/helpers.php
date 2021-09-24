<?php
if (!function_exists('render2')) {
	function render2($breadcrumb = array(), $title = '')
	{
	    if (empty($breadcrumb)) {
                return false;
            }
            if (empty($title)) {
                $title = __('Dashboard');
            }
            $homeUrl = url('/home');
            $html = "<div class=\"col-sm-6\">";
            $html .= "<ol class=\"breadcrumb float-sm-right\">";
            $html .= "<li class=\"breadcrumb-item\"><a href=\"{$homeUrl}\">" . __('Dashboard') . "</a></li>";
            $i = 0;
            $len = count($breadcrumb);
            foreach ($breadcrumb as $item) {
              if (!isset($item['link'])) {
                  $item['link'] = url('/');
              }
              if (empty($item['link'])) {
                  $item['link'] = 'javascrpt:;';
              }
              
              if ($i == $len - 1) {
                if (!empty($item['name'])) {
                  $html .= "<li class=\"breadcrumb-item\">{$item['name']}</li>";
                }
              } else {
                if (!empty($item['name'])) {
                  $html .= "<li class=\"breadcrumb-item\"><a href=\"{$item['link']}\">{$item['name']}</a></li>";
                }
              }
              // …
              $i++;
            }
            $html .= "</ol>";
            $html .= "</div>";
            //$html .= "<h1>{$title}</h1>";
            return $html;
	}
}
