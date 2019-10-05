<template>
	<div class="container">
		<div class="row">
            <div class="col-md-5 col-xl-3">
                <div id="one-inbox-side-nav" class="d-none d-md-block push">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Solicitudes</h3>
                            <div class="block-options">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#one-inbox-new-message">
                                    <i class="fa fa-pencil-alt mr-1"></i> Nuevo
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <ul class="nav nav-pills flex-column font-size-sm push">
                                <li class="nav-item my-1">
                                    <a class="nav-link d-flex justify-content-between align-items-center active" href="">
                                        <span>
                                            <i class="fa fa-fw fa-inbox mr-1"></i> Solicitudes
                                        </span>
                                        <span class="badge badge-pill badge-secondary">3</span>
                                    </a>
                                </li>
                                <li class="nav-item my-1">
                                    <a class="nav-link d-flex justify-content-between align-items-center" href="javascript:void(0)">
                                        <span>
                                            <i class="fa fa-fw fa-star mr-1"></i> Enviadas
                                        </span>
                                        <span class="badge badge-pill badge-secondary">48</span>
                                    </a>
                                </li>
                                <li class="nav-item my-1">
                                    <a class="nav-link d-flex justify-content-between align-items-center" href="javascript:void(0)">
                                        <span>
                                            <i class="fa fa-fw fa-trash-alt mr-1"></i> Canceladas
                                        </span>
                                        <span class="badge badge-pill badge-secondary">10</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
<!--                     <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Autoridades</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-settings"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <ul class="nav-items font-size-sm">
                                <li>
                                    <a class="media py-2" href="javascript:void(0)">
                                        <div class="mr-3 ml-2 overlay-container overlay-bottom">
                                            <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar2.jpg" alt="">
                                            <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                        </div>
                                        <div class="media-body">
                                            <div class="font-w600">Sara Fields</div>
                                            <div class="font-w400 text-muted">Web Designer</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>

            <div class="col-md-7 col-xl-9">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            15-30 <span class="font-w400 text-lowercase">de</span> 700
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="tooltip" data-placement="left" title="Previous 15 Messages">
                                <i class="si si-arrow-left"></i>
                            </button>
                            <button type="button" class="btn-block-option" data-toggle="tooltip" data-placement="left" title="Next 15 Messages">
                                <i class="si si-arrow-right"></i>
                            </button>
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                        </div>
                    </div>
                    <div class="block-content">
                    	<div class="mb-5">
	                        <button class="btn btn-sm btn-light float-right" type="button">
	                            <i class="fa fa-stop text-danger"></i>
	                            <span class="d-none d-sm-inline ml-1">Cancelar</span>
	                        </button>
                    	</div>
                        <div class="pull-x">
                            <table class="js-table-checkable table table-hover table-vcenter font-size-sm">
                                <tbody>
                                    <tr>
                                        <td class="text-center" style="width: 60px;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="inbox-msg15" name="inbox-msg15">
                                                <label class="custom-control-label font-w400" for="inbox-msg15"></label>
                                            </div>
                                        </td>
                                        <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">Ralph Murray</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">Welcome to our service</a>
                                            <div class="text-muted mt-1">It's a pleasure to have you on our service..</div>
                                        </td>
                                        <td class="d-none d-xl-table-cell text-muted" style="width: 80px;">
                                            <i class="fa fa-paperclip mr-1"></i> (3)
                                        </td>
                                        <td class="d-none d-xl-table-cell text-muted" style="width: 120px;">
                                            <em>Hace 2 minuto</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 60px;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="inbox-msg15" name="inbox-msg15">
                                                <label class="custom-control-label font-w400" for="inbox-msg15"></label>
                                            </div>
                                        </td>
                                        <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">John Smith</td>
                                        <td>
                                            <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">Welcome to our service</a>
                                            <div class="text-muted mt-1">It's a pleasure to have you on our service..</div>
                                        </td>
                                        <td class="d-none d-xl-table-cell text-muted" style="width: 80px;">
                                            <i class="fa fa-paperclip mr-1"></i> (3)
                                        </td>
                                        <td class="d-none d-xl-table-cell text-muted" style="width: 120px;">
                                            <em>Hace 2 minuto</em>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>