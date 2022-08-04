<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->


    <div class="row">
        <div class="col-lg col-md col-sm">
            <!-- untuk memunculkan error -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>
            <!-- Button trigger modal -->
            <a href="" class="btn btn-primary mb-3 add" data-toggle="modal" data-target="#newSubMenu">Add New Sub Menu</a>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Submenu Website</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Menu</th>
                                    <th scope="col">Url</th>
                                    <th scope="col">Icon</th>
                                    <th scope="col">Active</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($subMenu as $sm) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $sm['title']; ?></td>
                                        <td><?= $sm['menu']; ?></td>
                                        <td><?= $sm['url']; ?></td>
                                        <td><?= $sm['icon']; ?></td>
                                        <td><?= $sm['is_active']; ?></td>
                                        <td>
                                            <a href="<?= base_url('menu/submenu') ?>" class="badge badge-success edit" data-toggle="modal" data-target="#newSubMenu" data-id="<?= $sm['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="" class="badge badge-danger deleteSubMenu" data-id="<?= $sm['id']; ?>"><i class="fas fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- MODAL (bootstrap) -->
<!-- Modal Add Sub Menu-->
<div class="modal fade" id="newSubMenu" tabindex="-1" aria-labelledby="newSubMenuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuLabel">Label</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="POST">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="title" id="title" class="form-control" placeholder="Sub Menu title...">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="">Select Menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="url" id="url" class="form-control" placeholder="Sub Menu url...">
                    </div>
                    <!-- <div class="form-group">
                        <input type="text" name="icon" id="icon" class="form-control" placeholder="Sub Menu icon...">
                    </div> -->
                    <div class="form-group">
                        <!-- array icon fontAwesome untuk pilihan icon yang mau di pakai -->
                        <?php
                        $iconFas = ['code', 'user', 'folder', 'lock', 'list', 'photo-video', 'camera-retro', 'camera', 'video', 'globe-africa', 'globe-europe', 'project-diagram', 'wrench', 'address-card', 'quote-right'];
                        $iconFab = ['youtube', 'facebook-square', 'facebook', 'whatsapp', 'twitter'];
                        ?>
                        <div class="input-group-prepend bg-dark text-white p-2">
                            <div class="container">
                                <div class="row" id="current" style="visibility: hidden;">
                                    <div class="col-lg-12">
                                        <h5 class="text-muted">Current Icon</h5>
                                    </div>
                                    <div class="p-2 ml-3 rounded-0 bg-primary">
                                        <i id="currentIcon"><input type="hidden" name="iconDefault" id="iconDefault"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="text-muted">Change Icon</h5>

                                    </div>
                                    <?php
                                    for ($i = 0; $i < sizeof($iconFas); $i++) {
                                        echo "<div class='input-group-text ml-2 mt-1' style='width:70px;'>
                                        <i class='fas fa-$iconFas[$i]'><input type='radio' name='icon' class='ml-1' value='fas fa-fw fa-$iconFas[$i]' ></i>
                                    </div>";
                                    }
                                    ?>

                                    <?php
                                    for ($i = 0; $i < sizeof($iconFab); $i++) {
                                        echo "<div class='input-group-text ml-2 mt-1' style='width:70px;'>
                                        <i class='fab fa-$iconFab[$i]'><input type='radio' name='icon' class='ml-1' value='fab fa-fw fa-$iconFab[$i]' ></i>
                                    </div>";
                                    }
                                    ?>
                                    <div class="input-group-text ml-2 mt-1" style="width: 115px;">
                                        <a class="btn btn-light" onclick="tampilInputText(1);"><i class="fas fa-plus"></i> Lainnya</a>
                                    </div>
                                </div>

                                <div class="form-group" style="visibility: hidden;">
                                    <input type="text" name="iconInput" id="lainnya" class="form-control" placeholder="Sub Menu icon...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" checked value="1">
                            <label for="is_active" class="form-check-label">
                                Active?
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>