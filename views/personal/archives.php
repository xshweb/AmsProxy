<div class="article form-horizontal">
    <br>
    <?php foreach ( $this->getInfo() as $key => $value): ?>
    <div class="form-group">
        <label class="col-xs-5 control-label"><?php echo $key; ?></label>
        <div class="col-xs-7">
            <p class="form-control-static"><?php echo $value; ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>