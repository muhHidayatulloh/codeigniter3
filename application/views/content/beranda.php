<!-- begin page content -->
<div class="container-fluid">
    <!-- debugging -->
    <div class="alert-info">
        <p class="text">Ini Debugging : <?php var_dump("debug")
                                        ?>
        </p>
    </div>
    <!-- kategori -->
    <div class="row category-menu">
        <div class="row main-category ml-0 pl-3">
            <a href="#" data-toggle="modal" data-target="#modalKategori">
                <div class="item text-center">
                    <img src="<?= base_url(); ?>/assets/img/icon/category-more.svg">
                    <p>Pilih Kategori</p>
                </div>
            </a>
        </div>
    </div>

    <!-- beranda -->
    <div class="row">
        <?php foreach ($content as $c) : ?>
            <div class="col-lg-4 mt-2">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-4">
                                <div class="rounded-circle">
                                    <img src="<?= base_url('assets/img/profile/') . $c['image']; ?>" alt="gambar" class="img-thumbnail border-0" style="width: 80px; height:80px; border-radius:50%;">
                                </div>
                            </div>
                            <div class="col-8">
                                <h6 class="card-title"><?= $c['name']; ?></h6>
                                <small class="text-muted font-italic"><i class="fas fa-calendar-alt"></i> <?= date('l, d M Y H:i:s', $c['date_created_content']); ?></small>
                            </div>

                        </div>
                    </div>

                    <div class="card-body" style="height: 200px;">
                        <h5 class="card-title text-primary"><?= $c['content_title']; ?></h5>
                        <p class="card-text">
                            <?php
                            $data_content =  $c['content_body'];
                            $explode_data = explode("\r\n", $data_content);

                            echo $explode_data[0];

                            ?>
                        </p>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-5">
                                <a href="<?= site_url('content/contentView/' . $c['content_id']); ?>" class="btn btn-success btn-sm selengkapnya" data-id="<?= $c['content_id']; ?>">selengkapnya..</a>
                            </div>
                            <div class="col-7">
                                <a href="<?= base_url('content/contentView/' . $c['content_id'] . '#like'); ?>" class="btn btn-light btn-sm">
                                    <span>
                                        <i class="far fa-heart"></i>
                                    </span>
                                    <span>
                                        <?php
                                        $contentId = $c['content_id'];
                                        $query = $this->db->get_where('data_kunjungan', ['content_id' => $contentId, 'status_like' => 1])->num_rows();
                                        echo $query;
                                        ?>
                                    </span>
                                </a>
                                <a class="btn btn-light btn-sm" href="<?= base_url('content/contentView/' . $c['content_id'] . '#display_comment'); ?>">
                                    <span>
                                        <i class="fas fa-comment-dots"></i>
                                    </span>
                                    <span>
                                        <?php
                                        $id = $c['content_id'];
                                        $query = $this->db->get_where('table_comment', ['content_id' => $id])->num_rows();

                                        echo $query;

                                        ?>
                                    </span>
                                </a>
                                <a href="" class="btn btn-light btn-sm">
                                    <span>
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    <span>
                                        <?php
                                        $contentId = $c['content_id'];
                                        $query = $this->db->get_where('data_kunjungan', ['content_id' => $contentId])->num_rows();

                                        echo $query;
                                        ?>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- <div class="row mt-3">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    Berikan Komentar
                </div>
                <div class="card-body">

                    <p class="card-text">Content</p>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div> -->

</div>
<!-- ./container-fluid -->

</div>
<!-- end of main content -->

<style type="text/css">
    /* * {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: arial, sans-serif;
        font-size: 100%;
        margin: 3em;
        background: #666;
        color: #fff;
    } */

    h2,
    p {
        font-size: 100%;
        font-weight: normal;
    }

    ul.k,
    li {
        list-style: none;
    }


    ul.k li a {
        text-decoration: none;
        color: #000;
        background: #ffc;
        display: block;
        height: 100px;
        width: 100px;
        padding: 1em;
        margin-bottom: 10px;
        -moz-box-shadow: 5px 5px 7px rgba(33, 33, 33, 1);
        -webkit-box-shadow: 5px 5px 7px rgba(33, 33, 33, .7);
        box-shadow: 5px 5px 7px rgba(33, 33, 33, .7);
        -moz-transition: -moz-transform .15s linear;
        -o-transition: -o-transform .15s linear;
        -webkit-transition: -webkit-transform .15s linear;
        transition: .15s linear;
    }

    ul.k li {
        margin: 0.4em;
        float: left;
    }

    ul.k li h2 {
        font-size: 125%;
        font-weight: bold;
    }

    ul.k li p {
        font-family: "Reenie Beanie", arial, sans-serif;
        font-size: 12px;
    }

    ul.k li a {
        -webkit-transform: rotate(-6deg);
        -o-transform: rotate(-6deg);
        -moz-transform: rotate(-6deg);
        transform: rotate(-6deg);
    }

    ul.k li:nth-child(even) a {
        -o-transform: rotate(4deg);
        -webkit-transform: rotate(4deg);
        -moz-transform: rotate(4deg);
        transform: rotate(4deg);
        position: relative;
        top: 5px;
        background: #cfc;
    }

    ul.k li:nth-child(3n) a {
        -o-transform: rotate(-3deg);
        -webkit-transform: rotate(-3deg);
        -moz-transform: rotate(-3deg);
        transform: rotate(-3deg);
        position: relative;
        top: -5px;
        background: #ccf;
    }

    ul.k li:nth-child(5n) a {
        -o-transform: rotate(5deg);
        -webkit-transform: rotate(5deg);
        -moz-transform: rotate(5deg);
        transform: rotate(5deg);
        position: relative;
        top: -10px;
    }

    ul.k li a:hover,
    ul.k li a:focus {
        box-shadow: 10px 10px 7px rgba(0, 0, 0, .7);
        -moz-box-shadow: 10px 10px 7px rgba(0, 0, 0, .7);
        -webkit-box-shadow: 10px 10px 7px rgba(0, 0, 0, .7);
        -webkit-transform: scale(1.25);
        -moz-transform: scale(1.25);
        -o-transform: scale(1.25);
        transform: scale(1.25);
        position: relative;
        z-index: 5;
    }

    .fade {
        transform: scale(1.2);
    }
</style>

<div id="modalKategori" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalKategoriLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-transparent" style="border: 0;">
            <button class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="bg-danger">&times;</span>
            </button>
            <div class="modal-body">

                <div class="row category-menu">
                    <div class="row main-category">
                        <ul class="k">
                            <?php foreach ($kategori as $k) : ?>
                                <li>
                                    <a href="#">
                                        <h2><?= $k['nama']; ?></h2>
                                        <p>Text Content #1</p>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <a href="#">
                                    <h2>Other</h2>
                                    <p>Text Content #1</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                Footer
            </div> -->
        </div>
    </div>
</div>