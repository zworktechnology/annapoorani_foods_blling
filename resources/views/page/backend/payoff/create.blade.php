@extends('layout.backend.auth')

@section('content')

   <div class="content">
      <div class="page-header">
         <div class="page-title">
            <h4>Add Payoff</h4>
         </div>
      </div>



        <div class="card">
            <div class="card-body">
                <form autocomplete="off" method="POST" action="{{ route('payoff.store') }}" enctype="multipart/form-data">
                    @csrf


                  <div class="row">



                        
                        <div class="col-lg-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Date<span
                                        style="color: red;">*</span></label>
                                <input type="date" name="date" placeholder="" value="{{ $today }}" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label style="font-size:15px;padding-top: 5px;padding-bottom: 2px;">Month<span
                                        style="color: red;">*</span></label>
                                 <select class="form-control js-example-basic-single salary_month select" name="salary_month" id="salary_month"required>
                                    <option value="" selected hidden class="text-muted">Select Month </option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                 </select>
                            </div>
                        </div>

                        
                  </div>


                    <br />

                    <div class="row">
                        <div class="table-responsive col-lg-12 col-sm-12 col-12">
                            <table class="table">
                                <thead id="headsalary_detailrow" style="display:none">
                                    <tr style="background: #f8f9fa;">
                                        <th style="font-size:15px; width:24%;">Employee</th>
                                        <th style="font-size:15px; width:8%;">Days</th>
                                        <th style="font-size:15px; width:9%;">D / S</th>
                                        <th style="font-size:15px; width:13%;">Total Salary</th>
                                        <th style="font-size:15px; width:10%;">Paid</th>
                                        <th style="font-size:15px; width:11%;">Balance</th>
                                        <th style="font-size:15px; width:25%;">Salary</th>
                                    </tr>
                                </thead>
                                <tbody id="salary_detailrow">
                                </tbody>
                            </table>
                        </div>
                  </div>

<script>
$(document).ready(function() {
     $('.salary_month').on('change', function () {
        var salary_month = $(this).val();
        //alert(salary_month);
        $.ajax({
            url: '/gettotpresentdays/',
            type: 'get',
            data: {
                salary_month: salary_month
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                var len = response.length;
                $('#salary_detailrow').html('');
                for (var i = 0; i < len; i++) {

                        var column_0 = $('<td/>', {
                            html: '<input type="hidden" id="employee_id" name="employee_id[]" value="' + response[i].id + '"/>' +
                                '<input type="text" id="employee_name" name="employee_name[]" style="background: white;" value="' + response[i].Employee + '" readonly class="form-control"/>',
                        });
                        var column_1 = $('<td/>', {
                            html: '<input type="text" id="total_presentdays" name="total_presentdays[]" style="background: white;" value="' + response[i].total_presentdays + '" readonly class="form-control"/><input type="hidden" id="totaldays" name="totaldays[]"  readonly style="background: white;" value="' + response[i].total_days + '" class="form-control"/>',
                        });
                        var column_2 = $('<td/>', {
                            html: '<input type="text" id="perdaysalary" name="perdaysalary[]" style="background: white;" value="' + response[i].perdaysalary + '" readonly class="form-control"/>',
                        });
                        var column_3 = $('<td/>', {
                            html: '<input type="text" id="total_salaryamount" name="total_salaryamount[]" style="background: white;color: #198754;font-weight:800;" value="' + response[i].total_salary + '" readonly class="form-control total_salaryamount"/>',
                        });
                        var column_4 = $('<td/>', {
                            html: '<input type="text" id="paid_salaryamount" name="paid_salaryamount[]" style="background: white;color: red;font-weight:800;" value="' + response[i].paid_salary + '" readonly class="form-control paid_salaryamount"/>',
                        });
                        var column_5 = $('<td/>', {
                            html: '<input type="text" id="balncesalary" name="balncesalary[]" style="background: #bbee9a;" value="' + response[i].balanceAmount + '" readonly class="form-control paid_salaryamount"/>',
                        });
                        var column_6 = $('<td/>', {
                            html: '<input type="text" class="form-control amountgiven" id="amountgiven" name="amountgiven[]" ' + response[i].readonly + '  style="background: #f8f9fa;" placeholder="' + response[i].placeholder + '"/>',
                        });

                        var row = $('<tr id=salrydetailrow/>', {}).append(column_0, column_1, column_2,
                            column_3, column_4, column_5, column_6);

                        $('#salary_detailrow').append(row);
                        $('#headsalary_detailrow').show();
                }
            }
        });
    });

    $(document).on("keyup", "input[name*=amountgiven]", function() {
        var amountgiven = $(this).val();
        var total_salaryamount = $(this).parents('tr').find('.total_salaryamount').val();
        var paid_salaryamount = $(this).parents('tr').find('.paid_salaryamount').val();
        var balanceSalary = Number(total_salaryamount) - Number(paid_salaryamount);
        if (Number(amountgiven) > Number(balanceSalary)) {
            alert('!Paid Amount is More than of Total!');
            $(this).parents('tr').find('.amountgiven').val('');
        }
    });
});



</script>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" />
                        <a href="{{ route('payoff.index') }}" class="btn btn-danger" value="">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection


