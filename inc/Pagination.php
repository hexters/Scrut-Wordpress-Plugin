<?php 

namespace App;

class Pagination {

  private $total;
  private $link;
  private $per_page = 10;
  private $page_parameter = 'p';
  private $current_total = 0;

  private $showing_page_link = 5;
  private $total_prefix_left = 3;
  
  public function setTotal(INT $total) {
    $this->total = $total;
  }
  
  public function setLink(String $link) {
    $this->link = $link;
  }

  public function setPageParameter(String $page_parameter) {
    $this->page_parameter = $page_parameter;
  }
  
  // 
  public function getTotal() {
    return $this->total;
  }
  
  public function getLink() {
    return $this->link;
  }

  public function getPerPage() {
   return (INT) $this->request('per_page', $this->per_page); 
  }
  
  public function getCurrentPage() {
    return (INT) $this->request($this->page_parameter, 1) == 0 ? 1 : $this->request($this->page_parameter, 1);
  }

  public function getOffset() {
    $current_page = $this->getCurrentPage();
    $perpage = (INT) $this->request('per_page', $this->per_page);
    $page = $current_page - 1;
    $offset = $page * $perpage;

    return $offset;
  }

  public function setCurrentTotal(INT $current_total) {
    $this->current_total = $current_total;
  }

  public function render() {  
    
    require_once( SCRUT__PLUGIN_DIR . '/inc/components/pagination/index.php');
  }

  public function custom($path, Array $data = []) {  
    if( file_exists( $path ) ) {
      require_once( $path );
    }
  }

  public function head($field, $name) {
    $params = [];
    foreach($_GET as $key => $param) {
      if(!($key == 'order') && !($key == 'short')) {
        $params[$key] = $param;
      }
    }

    $short = $this->request('short', 'asc') == 'asc' ? 'desc' : 'asc';
    $params = array_merge($params, [
      'order' => $field,
      'short' => $short
    ]);
    $result_params = count($params) > 0 ? '?' . http_build_query($params) : null;
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $uri = explode('?', $link);
    $target = $uri[0] .  $result_params;

    $html = '<a href="' . $target . '">';
    $html .= '<span>' . $name . '</span>';
    $html .= '<span class="sorting-indicator"></span>';
    $html .= '</a>';
    return $html;
  }

  public function getShort($field) {
    return $this->request('short', 'asc') && $this->request('order') == $field ? $this->request('short', 'asc') : '';
  }
  
  //

  public function isCurrentPage($page) {
    return $page == $this->getCurrentPage();
  }

  private function link(INT $page = 1) {
    $params = [];
    foreach($_GET as $key => $param) {
      if(!($key == $this->page_parameter)) {
        $params[$key] = $param;
      }
    }

    $params = array_merge($params, [ $this->page_parameter => $page ]);
    $result_params = count($params) > 0 ? '?' . http_build_query($params) : null;
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $uri = explode('?', $link);
    return $uri[0] .  $result_params;
  }

  private function totalPage() {
    return ceil($this->total / $this->getPerPage());
  }

  private function pageStart() {
    $page = $this->getCurrentPage();
    $offset = $page - $this->total_prefix_left;
    return $offset > 0 ? $offset : 1;
  }
  private function totalShowing() {
    $page = $this->getCurrentPage();
    $add_num = $this->current_total < $this->getPerPage() ? 0 : $this->total_prefix_left;
    $offset = $page + $add_num;
    $total = $this->totalPage();
    return $offset > $total ? $total : $offset;
  }

  private function firstPage() {
    return $this->link(1);
  }

  private function isFirstPage() {
    return $this->getCurrentPage() == 1;
  }

  private function isLastPage() {
    return $this->getCurrentPage() >= $this->totalPage();
  }

  private function lastpage() {
    $total = $this->totalPage();
    return $this->link($total);
  }

  private function prev() {
    $page = $this->getCurrentPage() - 1;
    return $this->link($page);
  }

  private function next() {
    $page = $this->getCurrentPage() + 1;
    return $this->link($page);
  }

  private function request($name, $default = null) {
    return isset($_REQUEST[$name]) ? trim($_REQUEST[$name]) : $default;
  }

}