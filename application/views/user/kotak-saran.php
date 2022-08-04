<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->



    <div class="row">

        <div class="col-lg-6">
            <!-- untuk memunculkan error -->
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>

            <!-- Kritik dan saran -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Kritik & Saran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url('assets/img/'); ?>svg/undraw_design_components.svg" alt="Img" />
                    </div>
                    <p>
                        Saran yang membangun akan sangat membantu kami dalam pengembangan web ini, maka dari itu kami selaku admin web bebarengan ingin menyampaikan terimakasih atas kritik dan saran yang sudah diberikan
                    </p>
                    <a href="<?= base_url('content'); ?>" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Back To Beranda</span>
                    </a>
                    <hr>
                    <div class="text-center">
                        <h6 class="font-weight-bold text-primary">Kirim Via</h6>
                        <a href="" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#modalSaran">
                            <span class="icon text-white-50">
                                <i class="fab fa-facebook"></i>
                            </span>
                            <span class="text">Facebook</span>
                        </a>
                        <a href="" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#modalSaran">
                            <span class="icon text-white-50">
                                <i class="fab fa-whatsapp"></i>
                            </span>
                            <span class="text">whatsapp</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6">
            <!-- Kritik dan saran -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Kritik & Saran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url('assets/img/'); ?>undraw_posting_photo.svg" alt="Img" />
                    </div>

                    <form action="<?= base_url(''); ?>" class="user">
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" id="email" class="form-control" value="<?= $user['email']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="saran" class="col-sm-2 col-form-label">Kritik & Saran</label>
                            <div class="col-sm-10">
                                <textarea name="saran" id="saran" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="from-group row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="far fa-paper-plane"></i>
                                    </span>
                                    <span class="text">Kirim</span>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- modal untuk saran via facebook atau whatsapp -->
<div id="modalSaran" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalSaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSaranLabel">Label</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>ini modal body</p>
            </div>
            <div class="modal-footer">
                ini modal footer
            </div>
        </div>
    </div>
</div>