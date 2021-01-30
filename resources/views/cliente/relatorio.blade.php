<!--Accordion -->
<div class="col-md-12">
    <div class="panel-group" id="accordion">
        <div class="card panel">
            <div class="card-head card-head-xs collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-1">
                <header>Relatórios</header>
                <div class="tools">
                    <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                </div>
            </div>
            <div id="accordion1-1" class="collapse">
                <div class="card-body">

                    @role('super-admin')
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="report_id" class="col-md-4 control-label">Relatórios</label>
                                <div class="col-md-8">
                                    <select   class="form-control input-sm" id="report_id" name="report_id">
                                        <option value="">Selecione</option>
                                        @foreach ($reports->pluck('name','modal_name')->all() as $key => $report)
                                            <option value="{{ $key }}" {{ old('report', isset($reports->id) ? $reports->id : null) == $key ? 'selected' : '' }}>
                                                {{ $report }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endrole



                </div>
            </div>
        </div><!--end .panel -->
    </div><!--end .panel-group -->
</div>