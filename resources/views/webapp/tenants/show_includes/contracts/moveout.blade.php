<div class="modal fade" id="moveoutTenant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Moveout</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="moveoutTenantForm"
                    action="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}/moveout"
                    method="POST">
                    {{ csrf_field() }}
                    @method('PUT')
                </form>
                <input type="hidden" form="moveoutTenantForm" id="unit_tenant_id" name="unit_tenant_id"
                    value="{{ $tenant->unit_tenant_id }}" required>
                <input type="hidden" form="moveoutTenantForm" id="tenant_id" name="tenant_id"
                    value="{{ $tenant->tenant_id }}" required>
                <div class=" row">
                    <div class="col">
                        <p class="text-center">{{ $tenant->first_name.' '.$tenant->last_name }} is ready to moveout in
                            on {{ Carbon\Carbon::parse($tenant->actual_moveout_at)->format('M d Y') }}. </p>

                    </div>
                </div>

                <div class="modal-footer">
                    <button form="moveoutTenantForm" type="submit" class="btn btn-primary btn-user btn-block"
                        onclick="this.form.submit(); this.disabled = true;">
                        Print Gatepass
                    </button>

                </div>

            </div>
        </div>
    </div>
</div>