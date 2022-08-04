<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row mb-2">
        <div class="col">
            <button class="btn btn-icon-split btn-secondary" data-target="#createArticle" data-toggle="collapse" aria-expanded="false" aria-controls="createArticle" id="btnMunculkanFormArticle">
                <span class="icon">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">
                    Create your article
                </span>
            </button>
        </div>
    </div>

    <?= $this->session->flashdata('message'); ?>

    <!-- creat article -->
    <div class="container border-light shadow py-2 mt-3 collapse" id="createArticle">
        <div class="row border-bottom-secondary">
            <div class="col py-2">
                <h6 class="card-title text-primary judul-header">Buat Tulisanmu Disini</h6>
            </div>
        </div>

        <div class="row pt-4">
            <div class="col-lg-12">
                <!-- form untuk membuat article -->
                <form action="<?= base_url('user/writearticle'); ?>" method="post" id="formArticle">
                    <input type="hidden" id="userid" name="id" value="<?= $user['id']; ?>">
                    <input type="hidden" name="content_id" id="contentid">
                    <div class="row">
                        <div class="p-2 col-lg-8 ">
                            <div class="form-group">
                                <label for="title">
                                    <h5 class="text" id="judul-content">Tulis Judul</h5>
                                </label>
                                <input id="title" class="form-control btn-outline-success" type="text" name="title">
                                <?= form_error('title', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                            </div>
                        </div>


                    </div>
                    <div class="row mt-2">
                        <div class="p-2 col-lg-12">
                            <div class="">
                                <label for="article">
                                    <h5 class="text" id="isi-content">Tulis Article Disini</h5>
                                </label>
                                <textarea name="articleBody" id="article"></textarea>
                            </div>
                            <?= form_error('articleBody', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                        </div>
                    </div>
                    <div class="row m-2 justify-content-end">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <span id="kategorispan">Kategori</span>
                                <select id="kategori" class="custom-select" name="kategori">
                                    <option id="pilihan">--Pilih--</option>
                                    <?php foreach ($kategori as $k) : ?>
                                        <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <span id="privasi-content">Status Publish</span>
                                <select id="privasi" class="custom-select" name="privasi">
                                    <option>--Pilih--</option>
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button type="reset" class="btn btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-sync"></i>
                                </span>
                                <span class="text">Reset</span>
                            </button>
                            <button type="submit" class="btn btn-primary btn-icon-split" id="btnCreate">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text" id="btntextCreate">Create</span>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- end of the form -->
            </div>
        </div>
    </div>
    <!-- end of create article -->


    <!-- start of table -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Kontenmu</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div>
                            <p class="text">Ket :</p>
                            <p><i class="fas fa-globe-asia"></i> Tulisan terlihat oleh semua user</p>
                            <p><i class="fas fa-lock"></i> tidak terlihat untuk user lain</p>
                            <p><i class="fas fa-question"></i> tidak diketahui, Tidak terlihat untuk semua</p>
                        </div>
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Tanggal Di Buat</th>
                                    <th scope="col">Privasi</th>
                                    <th scope="col">Viewers</th>
                                    <th scope="col">Like</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($content as $c) : ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $c['content_title']; ?></td>
                                        <td><?= date('l, d F o', $c['date_created_content']); ?></td>
                                        <td class="text-center">
                                            <?php

                                            $privasi = $c['status_publish'];
                                            if ($privasi === "public") {
                                                echo '<i class="fas fa-globe-asia"></i>';
                                            } else if ($privasi === "private") {
                                                echo '<i class="fas fa-lock"></i>';
                                            } else {
                                                echo '<i class="fas fa-question"></i>';
                                            }

                                            ?>
                                        </td>
                                        <?php
                                        $query = $this->db->get_where('data_kunjungan', ['content_id' => $c['content_id']])->num_rows();
                                        $this->db->select('status_like');
                                        $like = $this->db->get_where('data_kunjungan', ['content_id' => $c['content_id'], 'status_like' => 1])->num_rows();
                                        ?>
                                        <td class="text-center"><?= $query; ?></td>
                                        <td><?= $like; ?></td>
                                        <td>
                                            <a href="#" class="badge badge-success editContent" data-id="<?= $c['content_id']; ?>" data-target="#createArticle" data-toggle="collapse" aria-expanded="false" aria-controls="createArticle"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="#" class="badge badge-danger deleteContent" data-id="<?= $c['content_id']; ?>"><i class="fas fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of table -->


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- modal untuk edit content -->
<!-- <div id="modalContentManagement" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalManagementLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="modalManagementLabel">Edit</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('content/contentmanagement') ?>">
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input id="judul" class="form-control" type="text" name="judul">
                    </div>
                    <div class="form-group">
                        <label for="privasi">Status Publish</label>
                        <select name="privasi" id="privasi" class="form-control">
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="isi">Isi Tulisan</label>
                        <textarea name="isi" id="isi"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-icon-split btn-primary">
                    <span class="icon"><i class="fas fa-paper-plane"></i></span>
                    <span class="text">Edit</span>
                </button>
                </form>
            </div>
        </div>
    </div>
</div> -->