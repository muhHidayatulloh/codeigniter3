<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->

    <div class="row">
        <div class="col-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 col-md-8">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="<?= $user['image']; ?>" class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-fw fa-user"></i> <?= $user['name']; ?></h5>
                            <p class="card-text"><i class="fas fa-fw fa-mail-bulk"></i> <?= $user['email']; ?></p>
                            <p class="card-text"><small class="text-muted"><i class="fas fa-fw fa-calendar-times"></i> Member since <?= date('d F Y', $user['date_created']); ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-4">
            <img src="<?= base_url('assets/img/svg/'); ?>undraw_profile_details.svg" alt="img svg" class="w-100 h-100 align-content-end">
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->