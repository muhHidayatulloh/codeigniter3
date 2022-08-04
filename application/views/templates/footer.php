<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Muhhi's Comp <?= date('Y') ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to exit</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url(); ?>vendor/ckeditor/ckeditor/ckeditor.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

<!-- script custom -->
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            }
        });
    });

    function tampilInputText(nilai, identitas) {
        if (nilai == 1)
            document.getElementById('lainnya').style.visibility = 'visible';
        else
            document.getElementById('lainnya').style.visibility = 'hidden';
    }

    function tampilCurrent(nilai, identitas) {
        if (nilai == 1)
            document.getElementById('current').style.visibility = 'visible';
        else
            document.getElementById('current').style.visibility = 'hidden';
    }
</script>

<!-- start script of menu management and submenu management -->
<script>
    $(function() {
        //mengubah judul modal untuk tombol add new sub Menu submenu management
        $('.add').on('click', function() {
            $('#newSubMenuLabel').html('Add New Sub Menu');
            $('.modal-footer button[type=submit]').html('Add');
            $('#title').val("");
            $('#menu_id').val("");
            $('#url').val("");
        });

        // proses memunculkan modal edit pada menu submenu management dan proses ajax
        $('.edit').on('click', function() {
            $('#newSubMenuLabel').html('Edit Sub Menu');
            $('.modal-footer button[type=submit]').html('Edit');
            $('.modal-content form').attr('action', '<?= base_url('menu/ubahSubMenu'); ?>');
            const subMenuId = $(this).data('id');
            $.ajax({
                url: "<?= base_url('menu/subMenuEdit'); ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    id: subMenuId
                },
                success: function(data) {
                    $('#title').val(data.title);
                    $('#menu_id').val(data.idMenu);
                    $('#url').val(data.url);
                    tampilCurrent(1);
                    $('#currentIcon').addClass(data.icon);
                    $('#is_active').val(data.is_active);
                    $('#id').val(data.id);
                    $('#iconDefault').val(data.icon);
                }
            });
        });
    });
</script>

<script>
    $(function() {
        $(".addMenu").on("click", function() {
            $("#newMenuModalLabel").html("Add New Menu");
            $(".modal-footer button[type=submit]").html("Add");
        });

        $(".editMenu").on("click", function() {
            $("#newMenuModalLabel").html("Edit Menu");
            $(".modal-footer button[type=submit]").html("Edit");
            const idMenu = $(this).data("id");
            $('.modal-content form').attr('action', '<?= base_url('menu/ubahMenu'); ?>');

            $.ajax({
                url: "<?= base_url('menu/menuEdit'); ?>",
                type: "post",
                dataType: "json",
                data: {
                    id: idMenu,
                },
                success: function(data) {

                    $("#menu").val(data.menu);
                    $("#id").val(data.id);
                },
            });
        });

        $(".deleteMenu").on('click', function() {
            var konfirmasi = confirm('Yakin ingin menghapus ?');
            const idMenu = $(this).data('id');
            if (konfirmasi) {
                $.ajax({
                    url: "<?= base_url('menu/deleteDataMenu'); ?>",
                    type: 'post',
                    data: {
                        id: idMenu
                    }
                });
            } else {

            }
        });
        $(".deleteSubMenu").on('click', function() {
            var konfirmasi = confirm('Yakin ingin menghapus ?');
            const idSubMenu = $(this).data('id');
            if (konfirmasi) {
                $.ajax({
                    url: "<?= base_url('menu/deleteDataSubMenu'); ?>",
                    type: 'post',
                    data: {
                        id: idSubMenu
                    }
                });
            }
        });
        $(".deleteRole").on('click', function() {
            var konfirmasi = confirm('Yakin ingin menghapus ?');
            const idRole = $(this).data('id');
            if (konfirmasi) {
                $.ajax({
                    url: "<?= base_url('admin/deleteDataRole'); ?>",
                    type: 'post',
                    data: {
                        id: idRole
                    }
                });
            }
        });
    });
</script>
<!-- end of script menu management and sub menu management -->

<!-- start of menu Role script -->
<script>
    $(function() {
        $(".addRole").on("click", function() {
            $("#newRoleModalLabel").html("Add New Role");
            $(".modal-footer button[type=submit]").html("Add");
        });

        $(".editRole").on("click", function() {
            $("#newRoleModalLabel").html("Edit Role");
            $(".modal-footer button[type=submit]").html("Edit");
            const idRole = $(this).data("id");
            $('.modal-content form').attr('action', '<?= base_url('admin/ubahRole'); ?>');

            $.ajax({
                url: "<?= base_url('admin/editRole'); ?>",
                type: "post",
                dataType: "json",
                data: {
                    id: idRole,
                },
                success: function(data) {
                    $("#role").val(data.role);
                    $("#id").val(data.id);
                },
            });
        });
    });
</script>
<!-- end of menu role script -->

<!-- untuk memunculkan PLUGIN CKEDITOR -->
<script>
    var url = window.location.toString();
    var ada = url.indexOf('writearticle');
    var ada2 = url.indexOf('writearticle/');
    var ada3 = url.indexOf('writeArticle');
    var ada4 = url.indexOf('contentmanagement');
    if (ada > 0) {
        CKEDITOR.replace('article', {
            uiColor: "#f6c23e",
            height: "400"
        });
    } else if (ada2 > 0) {
        CKEDITOR.replace('article', {
            uiColor: "#f6c23e",
            height: "400"
        });
    } else if (ada3 > 0) {
        CKEDITOR.replace('article', {
            uiColor: "#f6c23e",
            height: "400"
        });
    } else if (ada4 > 0) {
        CKEDITOR.replace('article', {
            filebrowserImageBrowseUrl: '<?= base_url('vendor/kcfinder/browse.php'); ?>',
            uiColor: "#f6c23e",
            height: "400",
        });
        // CKEDITOR.replace('isi', {
        //     uiColor: "#f6c23e",
        //     height: "400"
        // });
    } else {
        console.log('no need ckeditor');
    }
</script>




<!-- untuk komentar balasan -->
<script>
    $('.balas').on('click', function() {
        const parentId = $(this).data('id');
        const nama = $(this).data('nama');
        $('#parentId').val(parentId);
        $('#nama').html(nama);
    });
</script>

<!-- script untuk like dan unlike -->
<script>
    $('.likebtn').click(function() {
        var contentId = $(this).data('id');



        $.ajax({
            url: "<?= base_url('content/like/'); ?>" + contentId,

            success: function(result) {

            }
        });

    });
</script>


<!-- untuk jumlah viewer -->
<script>
    $('.selengkapnya').click(function() {
        var contentId = $(this).data('id');

        $.ajax({
            url: "<?= base_url('content/view/'); ?>" + contentId,

            success: function(result) {

            }
        });
    });
</script>

<!-- start of menu content script -->

<!-- untuk create article -->
<script>
    $('#btnMunculkanFormArticle').click(function() {
        $('#btntextCreate').html('Create');
        $('#contentid').val('');
        $('#title').val('');
        CKEDITOR.instances['article'].setData('');
        $('.judul-header').html('Buat Tulisanmu');
        $('#judul-content').html('Tulis Judul');
        $('#isi-content').html('Tulis Isi');
        $('#privasi-content').html('Pilih Status Publish');
        $('#kategorispan').html('Kategori');
    });
</script>

<script>
    // untuk edit content
    $('.editContent').click(function() {
        $('#btntextCreate').html('Edit');
        $('.judul-header').html('Edit Tulisanmu');
        $('#judul-content').html('Ubah Judul');
        $('#isi-content').html('Ubah Isi');
        $('#privasi-content').html('Ubah Status Publish');
        $('#kategorispan').html('Ubah Kategori');

        var contentId = $(this).data('id');

        $.ajax({
            url: "<?= base_url('user/editContent'); ?>",
            type: "post",
            dataType: "json",
            data: {
                contentId: contentId
            },
            success: function(data) {
                console.log(data);
                $('#contentid').val(data.content_id);
                $('#title').val(data.content_title);
                CKEDITOR.instances['article'].setData(data.content_body);
            }
        });
    });

    // untuk delete content
    $('.deleteContent').on('click', function() {
        var konfirmasi = confirm("yakin ingin menghapus content ini ?");
        const id = $(this).data('id');

        if (konfirmasi) {
            $.ajax({
                url: "<?= base_url('user/deletecontent'); ?>",
                type: 'post',
                data: {
                    id: id
                },
                success: function() {

                }
            });
        } else {

        }
    });
</script>
<!-- end of menu content script -->



</body>

</html>