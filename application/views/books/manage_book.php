<h2><?php echo $title; ?></h2>

<div class="col-xs-12">
    <?php 
        if(!empty($success_msg)){
            echo '<div class="alert alert-success">'.$success_msg.'</div>';
        }elseif(!empty($error_msg)){
            echo '<div class="alert alert-danger">'.$error_msg.'</div>';
        }
    ?>
</div>
<?php echo validation_errors(); ?>
<form method="post" action="">
    <div class="row">
		<input type="hidden" name="action" value="<?php echo $action; ?>">
		<input type="hidden" name="book_id" value="<?php echo $book->id; ?>">
		<div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">Book:</label>
                <div class="col-md-9">
                    <label><?php echo $book->name; ?></label>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">Issue date:</label>
                <div class="col-md-9">
                    <div class="input-group date">
					<?php if($action == 'return') { ?>
						<input type="text" class="form-control datepicker" name="issue_date" disabled value="<?php if( isset($allocated_book) ) { echo $allocated_book->issue_date; } ?>">
					<?php } else { ?>
						<input type="text" class="form-control datepicker" name="issue_date" value="<?php echo set_value('issue_date'); ?>">
					<?php } ?>
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</div>
					</div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">Issue to user:</label>
                <div class="col-md-9">
                    <select class="form-control" name="user_id" <?php if( $action == 'return' ) { echo 'disabled'; } ?> >
						<option value="" <?php echo  set_select('user_id', '', true); ?> >select user</option>
						<?php
						foreach( $users as $user ) {
							?><option value="<?php echo $user['id'] ?>" <?php echo set_select('user_id', $user['id']); ?> <?php if( $action == 'return' && isset($allocated_book) && $allocated_book->user_id == $user['id'] ) { echo 'selected'; } ?> ><?php echo $user['name']; ?></option><?php
						}
						?>
					</select>
                </div>
            </div>
        </div>
		<div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">Return date:</label>
                <div class="col-md-9">
                    <div class="input-group date">
						<input type="text" class="form-control datepicker" name="return_date" <?php if( $action == 'issue' ) { echo 'disabled'; } ?> value="<?php echo set_value('return_date'); ?>">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</div>
					</div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2 pull-right">
            <input type="submit" name="bookSubmit" value="Save" class="btn" <?php if( $action == 'return' && !isset($allocated_book) ){ echo 'disabled'; } ?> >
			<a href="<?php echo base_url('books'); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
        </div>
    </div>
    
</form>
<script>
    $(document).ready(function(){
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
			minDate: new Date()
		});
    })
</script>