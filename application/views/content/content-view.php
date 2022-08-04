<!-- begin page content -->
<div class="container-fluid">
    <!-- debugging -->
    <div class="alert-info">
        <p class="text">Ini Debugging : </p>
        <p><?= var_dump(count($queryParent)) ?></p>
        <p><?= var_dump($data_kunjungan) ?></p>

    </div>

    <p id="alert"></p>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header">
                    <a href="<?= base_url('content'); ?>" class="btn btn-icon-split close">
                        <span class="icon">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                    </a>
                    <ol class="breadcrumb bg-light">
                        <li class="breadcrumb-item active" aria-current="page">Beranda</li>
                        <li class="breadcrumb-item"><?= $content['content_title']; ?></li>
                    </ol>
                </div>


                <div class="card-body">


                    <div class="text-center">
                        <img class="rounded-circle" src="<?= base_url('assets/img/profile/') . $content_user['image']; ?>" alt="gambar profile" style="width: 100px; height: 100px;">
                    </div>

                    <div class="text-center mt-2">
                        <h4 class="text-center">
                            <?= $content_user['name']; ?>
                        </h4>
                        <h6 class="text-center">
                            <i class="fas fa-fw fa-calendar"></i><small class="text-muted Italic"> <?= date('l, d F Y', $content['date_created_content']); ?></small>
                        </h6>

                    </div>


                    <h4 class="py-2 font-weight-bolder"><?= $content['content_title']; ?></h4>

                    <p class="card-text mt-2"><?= $content['content_body']; ?></p>
                </div>

                <div class="card-footer text-center" id="like">

                    <?php if ($data_kunjungan > 0) { ?>
                        <?php if ($data_kunjungan['status_like'] === "1") { ?>
                            <p>Thank you for your like</p>
                            <a href="" class="btn btn-light likebtn btn-circle border bg-danger" data-id="<?= $this->uri->segment('3'); ?>" data-userId="<?= $user['id']; ?>">
                                <i class="far fa-thumbs-up"></i>
                            </a>
                        <?php } else if ($data_kunjungan['status_like'] === "0") { ?>
                            <p>Like this content</p>
                            <a href="" class="btn btn-light likebtn btn-circle border" data-id="<?= $this->uri->segment('3'); ?>" data-userId="<?= $user['id']; ?>">
                                <i class="far fa-thumbs-up"></i>
                            </a>
                        <?php } ?>
                    <?php } else { ?>
                        <p>Like this content</p>
                        <a href="" class="btn btn-light likebtn btn-circle border" data-id="<?= $this->uri->segment('3'); ?>" data-userId="<?= $user['id']; ?>">
                            <i class="far fa-thumbs-up"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-5">
            <div class="card shadow">
                <div class="card-header text-center">
                    Berikan Komentar
                </div>
                <div class="card-body">



                    <form method="post" id="form-komen" action="<?= base_url('content/insertKomentar'); ?>">
                        <div class="form-group">
                            <label for="name">Nama : </label>
                            <input id="name" class="form-control" type="text" name="name" value="<?= $user['name']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" class="form-control" type="text" name="email" value="<?= $user['email']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="isi">Komen</label>
                            <textarea id="isi" class="form-control" type="text" name="isi"></textarea>
                        </div>
                        <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                        <input type="hidden" name="parent" value="0">
                        <input type="hidden" name="content_id" value="<?= $this->uri->segment('3'); ?>">

                        <button class="btn btn-icon-split btn-primary" type="submit">
                            <span class="icon text-white-50">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <span class="text">Kirim Komentar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">

            <div class="card" id="display_comment">
                <div class="card-header">
                    Komentar
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('message'); ?>
                    <!-- perulangan untuk mengambil data dari table comment yang parent id nya sama dengan 0 dan contentnya sama dengan yang dibuka sekarang querynya ada di controler content dibagian function contentView -->
                    <?php if (count($queryParent) > 0) { ?>
                        <?php foreach ($queryParent as $qP) : ?>
                            <div class="media p-3">
                                <img src="<?= base_url('assets/img/profile/') . $qP['image']; ?>" alt="gambar profile" class="mr-3 mt-3 rounded-circle" style="width: 80px; height: 80px;">
                                <div class="media-body">
                                    <h5><b><?= $qP['name']; ?></b> <small class="text-muted"><i>Posted on <?= date('l, d F y', $qP['date_created']); ?></i></small></h5>
                                    <p><?= $qP['isi']; ?></p>

                                    <button class="btn btn-primary balas" data-toggle="modal" data-target="#balasKomentar" data-id="<?= $qP['id']; ?>" data-nama="<?= $qP['name']; ?>">Balas</button>

                                    <div class="p-3"></div>

                                    <?php
                                    $contentId = $this->uri->segment('3');
                                    $commentId = $qP['id'];
                                    $this->db->select('table_comment.*, user.name, user.email, user.image');
                                    $this->db->order_by('table_comment.id', 'DESC');
                                    $this->db->join('user', 'user.id = table_comment.user_id');
                                    $queryChild = $this->db->get_where('table_comment', ['parent_id' => $commentId, 'content_id' => $contentId])->result_array();

                                    foreach ($queryChild as $qC) :
                                    ?>
                                        <div class="media p-3">
                                            <img src="<?= base_url('assets/img/profile/') . $qC['image']; ?>" alt="gambar profile" class="mr-3 mt-3 rounded-circle" style="width: 80px; height: 80px;">
                                            <div class="media-body">
                                                <h5><b><?= $qC['name']; ?></b> <small><i>Posted on <?= date('l, d F y', $qC['date_created']); ?></i></small></h5>
                                                <p class="text-black-50"><?= $qC['isi']; ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php } else {
                        echo "<div class='alert alert-info text-center'>
                                Belum ada komentar
                                </div>";
                    }

                    ?>
                </div>
            </div>
        </div>

    </div>


</div>
<!-- ./container-fluid -->

</div>
<!-- end of main content -->

<!-- modal untuk balas komentar -->
<div id="balasKomentar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="balasKomentarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="balasKomentarLabel">Balas Komentar</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Balas komentar dari <b id="nama"></b></p>
                <form action="<?= base_url('Content/insertBalasKomentar'); ?>" method="POST">
                    <input type="text" name="parentId" id="parentId">
                    <input type="text" name="userId" value="<?= $user['id']; ?>">
                    <input type="text" name="contentId" value="<?= $this->uri->segment('3'); ?>">
                    <div class="form-group">
                        <textarea name="balasan" id="balasan" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-icon-split btn-success" type="submit">
                            <span class="icon text-white-50">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <span class="text">Kirim</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                Its Me
            </div>
        </div>
    </div>
</div>
<!-- end of modal -->