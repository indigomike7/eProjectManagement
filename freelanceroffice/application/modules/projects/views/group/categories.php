<section class="scrollable">
  <?php
      $sub_group = isset($_GET['view']) ? $_GET['view'] : '';
        $data['project_id'] = $project_id;
        $this -> load -> view('group/sub_group/categories',$data);
?>
</section>