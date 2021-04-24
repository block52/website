<?php
namespace bootstrap\sidebar;

use bootstrap\nav\Nav;
use common\Utils;

class SidebarCategories extends Sidebar
{
    public $title;
    public $username;
    public $userinfo;
    public $collapsible;
    public $navs = array();

    public function __construct($title, $username, $userinfo, $collapsible = false, $collapsed = false)
    {
        $this->title       = $title;
        $this->username    = $username;
        $this->userinfo    = $userinfo;
        $this->collapsible = $collapsible;
        $this->collapsed   = $collapsed;
    }

    public function addNav($nav_id, $nav_class)
    {
        $nav_obj_id = Utils::camelCase($nav_id);
        if ($this->collapsible === true) {
            if ($this->collapsed == true) {
                $this->title = '<a class="dropdown-toggle collapsed" data-toggle="collapse" href="#' . $nav_obj_id . '" role="button" aria-expanded="false" aria-controls="' . $nav_obj_id . '">' . $this->title . '</a>';
            } else {
                $this->title = '<a class="dropdown-toggle" data-toggle="collapse" href="#' . $nav_obj_id . '" role="button" aria-expanded="true" aria-controls="' . $nav_obj_id . '">' . $this->title . '</a>';
            }
        }
        $this->$nav_obj_id = new Nav($nav_obj_id, $nav_class);
        $this->navs[] = $this->$nav_obj_id;
    }
}
