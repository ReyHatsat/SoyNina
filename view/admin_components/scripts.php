
<!--end::Scrolltop-->
<!--end::Main-->
<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="<?=PATH_VIEW?>assets/plugins/global/plugins.bundle.js"></script>
<script src="<?=PATH_VIEW?>assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="<?=PATH_VIEW?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="<?=PATH_VIEW?>assets/js/custom/documentation/general/toastr.js"></script>
<script src="<?=PATH_VIEW?>assets/js/vendors/plugins/select2.init.js"></script>

<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="<?=PATH_VIEW?>assets/js/custom/widgets.js"></script>
<script src="<?=PATH_VIEW?>assets/js/custom/documentation/general/stepper.js"></script>
<script src="<?=PATH_VIEW?>assets/js/custom/landing.js"></script>
<script src="<?=PATH_VIEW?>assets/js/custom/apps/chat/chat.js"></script>
<script src="<?=PATH_VIEW?>assets/js/custom/modals/create-app.js"></script>
<script src="<?=PATH_VIEW?>assets/js/custom/modals/upgrade-plan.js"></script>
<script src="<?=PATH_VIEW?>assets/plugins/custom/prismjs/prismjs.bundle.js"></script>

<script src="<?=PATH_VIEW?>assets/plugins/custom/datatables/datatables.bundle.js"></script>
<link rel="stylesheet" href="<?=PATH_VIEW?>assets/plugins/custom/datatables/datatables.bundle.css">
<link rel="stylesheet" href="<?=PATH_VIEW?>assets/plugins/custom/prismjs/prismjs.bundle.css">
<link rel="stylesheet" href="<?=PATH_VIEW?>assets/sass/vendors/plugins/_select2.scss">

<!--end::Page Custom Javascript-->
<!--end::Javascript-->


<script src="<?=PATH_VIEW?>framework/fnon.min.js"" charset="utf-8"></script>
<?php
echo "<script>";
include(PATH_VIEW."framework/main.js");
echo "</script>";
?>
