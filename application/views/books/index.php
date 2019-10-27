<?php if ( !empty($this->session->flashdata('success_msg')) ) { ?>
    <div class="col-xs-12">
        <div class="alert alert-success"><?php echo $this->session->flashdata('success_msg'); ?></div>
    </div>
    <?php } elseif ( !empty($this->session->flashdata('error_msg')) ){ ?>
    <div class="col-xs-12">
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12">           
        <h2><?php echo $title; ?></h2>
     </div>
</div>
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
      <tr>
          <th>ID</th>
          <th>Name</th>
		<th>Actions</th>
      </tr>
  </thead>
  <tbody>
   <?php foreach ($books as $books_item) { ?>      
      <tr>
          <td><?php echo $books_item['id']; ?></td>
          <td><?php echo $books_item['name']; ?></td>
		  <td>
			 <a class="btn btn-info btn-xs" href="<?php echo base_url('books/issue_book/'.$books_item['id']) ?>">Issue</a>
			 <a class="btn btn-info btn-xs" href="<?php echo base_url('books/return_book/'.$books_item['id']) ?>">Return</a>
			 <a class="btn btn-info btn-xs" href="<?php echo base_url('books/check_status/'.$books_item['id']) ?>">Check Status</a>
		  </td>     
      </tr>
      <?php } ?>
  </tbody>
</table>
</div>