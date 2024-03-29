<div class="modal fade" id="moveoutTenantWarning" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pending Balance </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body">
        <div class="row">
          <div class="col">

            <div class="table-responsive text-nowrap">

              <table class="table">
                <tr>
                  {{-- <td></td> --}}
                  <th>Bill No</th>

                  <th>Particular</th>
                  <th>Period Covered</th>
                  <th class="text-right" colspan="3">Amount</th>

                </tr>
                @foreach ($balance as $item)
                <tr>
                  {{-- <td>
                      <form action="/billings/{{ $item->billing_id }}" method="POST">
                  @csrf
                  @method('delete')
                  <button title="remove this bill" type="submit"
                    class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
                    onclick="return confirm('Are you sure you want perform this action?');"><i
                      class="fas fa-times fa-sm text-white-50"></i></button>
                  </form>
                  </td> --}}
                  <td>{{ $item->bill_no }}</td>

                  <td>{{ $item->particular }}</td>
                  <td>
                    {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                    {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                  </td>
                  <td class="text-right" colspan="3">{{ number_format($item->balance,2) }}</td>
                </tr>

                @endforeach
                <tr>
                  <th colspan="4">Total</th>
                  <th class="text-right">{{ number_format($balance->sum('balance'),2) }} </th>
                </tr>

              </table>

            </div>
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"
          data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Close</button>

      </div>



    </div>
  </div>

</div>