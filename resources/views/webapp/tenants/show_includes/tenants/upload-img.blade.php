<div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Image </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>

       
        <div class="modal-body">
         
         
       </div>
       <div class="modal-footer">
   
         <button title="balance has to be settled before moving out." href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{  $tenant->tenant_id }}/billings" form="extendTenantForm" class="btn btn-primary"><i class="fas fa-check fa-sm text-white-50"></i> Upload</button> 
      
     </div>
     
        
      
    </div>
    </div>

</div>