<?php echo $this->render('layouts/header.html',NULL,get_defined_vars(),0); ?>
<body class="animsition">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<?php echo $this->render('layouts/site.html',NULL,get_defined_vars(),0); ?>

<!-- Page -->
<div class="page">

    <div class="page-header">
        <h1 class="page-title">DataTables</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Tables</a></li>
            <li class="breadcrumb-item active">DataTables</li>
        </ol>
        <div class="page-header-actions">
            <button id="add_teacher" type="button" class="btn btn-outline btn-primary"><i class="icon wb-plus" aria-hidden="true"></i> Add</button>
        </div>
    </div>

    <div class="page-content">
        <!-- Panel Basic -->
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-actions"></div>
                <h3 class="panel-title">Basic</h3>
            </header>
            <div class="panel-body">
                <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>SChool_id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Enable</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>SChool_id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Enable</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach (($teachers?:[]) as $teacher): ?>
                        <tr>
                            <td><?= ($teacher->id) ?></td>
                            <td><?= ($teacher->school_id) ?></td>
                            <td><?= ($teacher->name) ?></td>
                            <td><?= ($teacher->email) ?></td>
                            <td><?= ($teacher->enable) ?></td>
                            <td><?= ($teacher->created_at) ?></td>
                            <td><?= ($teacher->updated_at) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Panel Basic -->
    </div>
</div>
<!-- End Page -->


<!-- Footer -->
<footer class="site-footer">
    <div class="site-footer-legal">© 2018 <a
            href="http://themeforest.net/item/remark-responsive-bootstrap-admin-template/11989202">Remark</a></div>
    <div class="site-footer-right">
        Crafted with <i class="red-600 wb wb-heart"></i> by <a href="https://themeforest.net/user/creation-studio">Creation
        Studio</a>
    </div>
</footer>
<?php echo $this->render('layouts/footer.html',NULL,get_defined_vars(),0); ?>
<script>

</script>