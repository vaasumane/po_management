<!DOCTYPE html>
<html>
<style media="screen">
  .form-group {
    margin-bottom: 0.5rem !important;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header pt-0 pb-2">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12 text-left mt-2">
              <h4>Dispatch Entry</h4>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card <?php if (!isset($update)) {
                                  echo 'collapsed-card';
                                } ?> card-default">
                <div class="card-header">
                  <h3 class="card-title"> <?php if (isset($update)) {
                                            echo 'Update';
                                          } else {
                                            echo 'Add New';
                                          } ?> Dispatch Entry</h3>
                  <div class="card-tools">
                    <?php if (!isset($update)) {
                      echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
                    } else { ?>
                      <a href="<?php echo base_url(); ?>Transaction/dispatch" class="btn btn-xs btn-outline-secondary px-4 mx-4">Cancel Edit</a>
                    <?php } ?>
                  </div>
                </div>
                <!--  -->
                <div class="card-body px-0 py-0" <?php if (isset($update)) {
                                                    echo 'style="display: block;"';
                                                  } else {
                                                    echo 'style="display: none;"';
                                                  } ?>>
                  <form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="row p-4">

                      <div class="form-group col-md-4 offset-md-2">
                        <label>Date<span class="text-danger">*</span></label>
                        <div class="input-group date" id="date1" data-target-input="nearest">
                          <input type="text" class="form-control form-control-sm datetimepicker-input" name="dispatch_date" id="date1" value="<?php if (isset($dispatch_info)) {
                                                                                                                                                echo $dispatch_info['dispatch_date'];
                                                                                                                                              } ?>" data-target="#date1" data-toggle="datetimepicker" required>
                        </div>
                      </div>
                      <div class="form-group col-md-4 select_sm">
                        <label>Customer<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="party_id" id="party_id" data-placeholder="Select Customer" required>
                          <option value="">Select Customer</option>
                          <?php if (isset($party_list)) {
                            foreach ($party_list as $list) { ?>
                              <option value="<?php echo $list->party_id; ?>" <?php if (isset($dispatch_info) && $dispatch_info['party_id'] == $list->party_id) {
                                                                                echo 'selected';
                                                                              }
                                                                              if ($list->party_status == '0') {
                                                                                echo ' disabled';
                                                                              } ?>><?php echo $list->party_name; ?></option>
                          <?php }
                          } ?>
                        </select>
                      </div>

                      <div class="form-group col-md-4 offset-md-2 select_sm">
                        <label>Finish Drawing No<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="item_id" id="item_id" data-placeholder="Select Finish Drawing No" required>
                          <option value="">Select Finish Drawing No</option>
                          <?php if (isset($item_list)) {
                            foreach ($item_list as $list) { ?>
                              <option value="<?php echo $list->item_id; ?>" <?php if (isset($dispatch_info) && $dispatch_info['item_id'] == $list->item_id) {
                                                                              echo 'selected';
                                                                            }
                                                                            if ($list->item_status == '0') {
                                                                              echo ' disabled';
                                                                            } ?>><?php echo $list->item_finished_drw_no; ?></option>
                          <?php }
                          } ?>
                        </select>
                      </div>

                      <div class="form-group col-md-4 select_sm">
                        <label>PO No<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="purchase_order_id" id="purchase_order_id" data-placeholder="Select PO No" required>
                          <option value="">Select PO No</option>
                          <?php if (isset($purchase_order_list)) {
                            foreach ($purchase_order_list as $list) { ?>
                              <option value="<?php echo $list->purchase_order_id; ?>" <?php if (isset($dispatch_info) && $dispatch_info['purchase_order_id'] == $list->purchase_order_id) {
                                                                                        echo 'selected';
                                                                                      }
                                                                                      if ($list->purchase_order_status == '0') {
                                                                                        echo ' disabled';
                                                                                      } ?>><?php echo $list->purchase_order_no; ?></option>
                          <?php }
                          } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-4 offset-md-2">
                        <label>PO Qty<span class="text-danger">*</span></label>
                        <div class="input-group date" data-target-input="nearest">
                          <input type="number" readonly class="form-control form-control-sm datetimepicker-input" name="po_qty" id="po_qty" value="<?php if (isset($dispatch_info)) {
                                                                                                                                                      echo $dispatch_info['dispatch_date'];
                                                                                                                                                    } ?>" data-target="#date1" data-toggle="datetimepicker" required>
                        </div>
                      </div>


                      <div class="form-group col-md-12">
                        <hr>
                        <div class="row">
                          <div class="col-md-6">
                            <p class="f-16"><b>Dispatch Entry Details</b></p>
                          </div>
                          <div class="col-md-6 text-right">
                            <button type="button" id="add_row1" class="btn btn-sm btn-info mb-3 mr-1" width="150px">Add Row</button>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <style media="screen">
                          #myTable1 td {
                            padding: 0.25rem !important;
                          }

                          .dropdown-menu {
                            z-index: 1200 !important;
                          }
                        </style>
                        <div class="">
                          <table id="myTable1" class="table table-bordered tbl_list">
                            <thead>
                              <tr>
                                <th class="f-14 wtm_150">Dispatched Qty</th>
                                <th class="f-14 wtm_150">Invoice No</th>
                                <th class="f-14 wtm_100">Dispatch Date</th>
                                <th class="f-14 wtm_100">Pending Qty</th>
                                <th class="f-14 ">Select Remark</th>
                                <th class="f-14 wt_50"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if (isset($dispatch_item_list)) {
                                $i = 0;
                                foreach ($dispatch_item_list as $list) { ?>

                                  <input type="hidden" name="input[<?php echo $i; ?>][dispatch_item_id]" value="<?php echo $list->dispatch_item_id; ?>">
                                  <tr>
                                    <td class="wtm_100">
                                      <input type="number" class="form-control form-control-sm dispatch_item_qty" onkeyup="dispatchQty(this)" name="input[<?php echo $i; ?>][dispatch_item_qty]" value="<?php echo $list->dispatch_item_qty; ?>" required>
                                    </td>
                                    <td class="wtm_100">
                                      <input type="text" class="form-control form-control-sm dispatch_item_inv_no" name="input[<?php echo $i; ?>][dispatch_item_inv_no]" value="<?php echo $list->dispatch_item_inv_no; ?>" required>
                                    </td>
                                    <td class="wtm_100">
                                      <div class="input-group date" id="po_item_due_date<?= $i; ?>" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm datetimepicker-input" name="input[<?php echo $i; ?>][dispatch_item_date]" value="<?php echo $list->dispatch_item_date; ?>" data-target="#po_item_due_date<?= $i; ?>" data-toggle="datetimepicker" required>
                                      </div>
                                    </td>
                                    <td class="wtm_100">
                                      <input type="number" class="form-control form-control-sm dispatch_item_pending_qty" name="input[<?php echo $i; ?>][dispatch_item_pending_qty]" value="<?php echo $list->dispatch_item_pending_qty; ?>" required>
                                    </td>
                                    <td class="select_sm wtm_150">
                                      <select class="form-control select2 form-control-sm remark_id w-100" name="input[<?php echo $i; ?>][remark_id]" data-placeholder="Select DRG No" required>
                                        <option value="">Select Remark</option>
                                        <?php if (isset($remark_list)) {
                                          foreach ($remark_list as $remark_list2) { ?>
                                            <option value="<?php echo $remark_list2->remark_id; ?>" <?php if ($remark_list2->remark_id == $list->remark_id) {
                                                                                                      echo ' selected';
                                                                                                    }
                                                                                                    if ($remark_list2->remark_status == 0) {
                                                                                                      echo ' disabled';
                                                                                                    } ?>><?php echo $remark_list2->remark_name; ?></option>
                                        <?php }
                                        } ?>
                                      </select>
                                    </td>
                                    <td class="wt_50">
                                      <?php if ($i > 0) { ?><a class="rem_row"><i class="fa fa-trash text-danger"></i></a><?php } ?>
                                    </td>
                                  </tr>
                                <?php $i++;
                                }
                              } else { ?>
                                <tr>
                                  <td class="wtm_100">
                                    <input type="number" class="form-control form-control-sm dispatch_item_qty" onkeyup="dispatchQty(this)" name="input[0][dispatch_item_qty]" required>
                                  </td>
                                  <td class="wtm_100">
                                    <input type="text" class="form-control form-control-sm dispatch_item_inv_no" name="input[0][dispatch_item_inv_no]" required>
                                  </td>
                                  <td class="wtm_100">
                                    <div class="input-group date" id="date2" data-target-input="nearest">
                                      <input type="text" class="form-control form-control-sm datetimepicker-input" name="input[0][dispatch_item_date]" value="" data-target="#date2" data-toggle="datetimepicker" required>
                                    </div>
                                  </td>
                                  <td class="wtm_100">
                                    <input type="number" class="form-control form-control-sm dispatch_item_pending_qty" name="input[0][dispatch_item_pending_qty]" required>
                                  </td>
                                  <td class="select_sm wtm_150">
                                    <select class="form-control select2 form-control-sm remark_id w-100" name="input[0][remark_id]" data-placeholder="Select DRG No" required>
                                      <option value="">Select Remark</option>
                                      <?php if (isset($remark_list)) {
                                        foreach ($remark_list as $remark_list2) { ?>
                                          <option value="<?php echo $remark_list2->remark_id; ?>" <?php if ($remark_list2->remark_status == 0) {
                                                                                                    echo ' disabled';
                                                                                                  } ?>><?php echo $remark_list2->remark_name; ?></option>
                                      <?php }
                                      } ?>
                                    </select>
                                  </td>
                                  <td class="wt_50"></td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                        <hr>
                      </div>

                      <div class="col-md-8 offset-md-2 pr-3">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="">Notes</label>
                              <textarea class="form-control form-control-sm " rows="4" name="dispatch_note" id="dispatch_note" rows="6"><?php if (isset($dispatch_info)) {
                                                                                                                                          echo $dispatch_info['dispatch_note'];
                                                                                                                                        } ?></textarea>
                            </div>
                          </div>

                        </div>
                      </div>

                    </div>
                    <div class="card-footer clearfix" style="display: block;">
                      <div class="row">
                        <div class="col-md-6 text-left">
                          <!-- <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" name="customer_status" id="customer_status" value="0" <?php if (isset($dispatch_info) && $dispatch_info['customer_status'] == 0) {
                                                                                                                                      echo 'checked';
                                                                                                                                    } ?>>
                          <label for="customer_status" class="custom-control-label">Disable This Dispatch Entry</label>
                        </div> -->
                        </div>
                        <div class="col-md-6 text-right">
                          <a href="<?php echo base_url(); ?>Transaction/dispatch" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
                          <?php if (isset($update)) {
                            echo '<button class="btn btn-sm btn-primary float-right px-4">Update</button>';
                          } else {
                            echo '<button class="btn btn-sm btn-success float-right px-4">Save</button>';
                          } ?>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Dispatch Entry List</h3>
                </div>
                <div class="card-body p-2" style="overflow-x: auto">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="d-none">#</th>
                        <th class="wtm_50">Action</th>
                        <th class="">Date</th>
                        <th class="">Party</th>
                        <th class="wt_100">Finish Drawing No</th>
                        <th class="wt_100">PO Number</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($dispatch_list)) {
                        $m = 0;
                        foreach ($dispatch_list as $list) {
                          $m++;
                          $party_data = $this->Master_Model->get_data('admi_party', 'party_name', ['party_id' => $list->party_id], '`party_id` DESC', 'row_array');
                          $item_data = $this->Master_Model->get_data('admi_item', 'item_finished_drw_no', ['item_id' => $list->item_id], '`item_id` DESC', 'row_array');
                          $purchase_order_data = $this->Master_Model->get_data('admi_purchase_order', 'purchase_order_no', ['purchase_order_id' => $list->purchase_order_id], '`purchase_order_id` DESC', 'row_array');
                      ?>
                          <tr>
                            <td class="d-none"><?php echo $m; ?></td>
                            <td class="text-center">
                              <div class="btn-group">
                                <a href="<?php echo base_url() ?>Transaction/edit_dispatch/<?php echo $list->dispatch_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary"></i></a>
                                <a href="<?php echo base_url() ?>Transaction/delete_dispatch/<?php echo $list->dispatch_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Dispatch Entry');"><i class="fa fa-trash text-danger"></i></a>
                                <!-- <a target="_blank" href="<?php echo base_url() ?>Transaction/dispatch_print/<?php echo $list->dispatch_id; ?>" type="button" class="btn btn-sm btn-default" ><i class="fa fa-print text-info"></i></a> -->
                              </div>
                            </td>
                            <td><?php echo $list->dispatch_date; ?></td>
                            <td><?php if ($party_data) {
                                  echo $party_data['party_name'];
                                } ?></td>
                            <td><?php if ($item_data) {
                                  echo $item_data['item_finished_drw_no'];
                                } ?></td>
                            <td><?php if ($purchase_order_data) {
                                  echo $purchase_order_data['purchase_order_no'];
                                } ?></td>
                          </tr>
                      <?php }
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Sale Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="update_dispatch_status" method="post">
            <div class="modal-body">
              <input type="hidden" name="dispatch_id" id="modal_dispatch_id2">
              <input type="hidden" name="customer_id" id="modal_customer_id2">
              <label for="">Select Status</label>
              <select class="form-control" name="dispatch_status" id="dispatch_status">
                <option value="1">Delivered</option>
                <option value="2">Cancelled</option>
                <option value="0">Pending</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

</body>

</html>

<script>
  // get_item_list_by_party...
  $("#party_id").on("change", function() {
    var party_id = $('#party_id').find("option:selected").val();
    $.ajax({
      url: '<?php echo base_url(); ?>Master/get_item_list_by_party',
      type: 'POST',
      data: {
        "party_id": party_id
      },
      context: this,
      success: function(result) {
        $('#item_id').html(result);
      }
    });
  });

  // get_item_list_by_party...
  $("#item_id,#party_id").on("change", function() {
    var item_id = $('#item_id').find("option:selected").val();
    var party_id = $('#party_id').find("option:selected").val();
    $.ajax({
      url: '<?php echo base_url(); ?>Master/get_purchase_order_list_by_item2',
      type: 'POST',
      data: {
        "item_id": item_id,
        "party_id": party_id
      },
      context: this,
      success: function(result) {
        $('#purchase_order_id').html(result);
      }
    });
  });
  $('#purchase_order_id').on('select2:select', function(e) {
    var qtyValue = $(e.params.data.element).data('qty');

    console.log(qtyValue);

    $('#po_qty').val(qtyValue);
  });
</script>

<script>
  // Add Row...  Jewellery
  <?php if (isset($update)) { ?>
    var i = <?php echo $i - 1; ?>
  <?php } else { ?>
    var i = 0;
  <?php } ?>

  $(document).on('click', '#add_row1', function() {
    i++;
    var row = '' +
      '<tr>' +
      '<td class="wtm_100">' +
      '<input type="number" class="form-control form-control-sm dispatch_item_qty" onkeyup="dispatchQty(this)" name="input[' + i + '][dispatch_item_qty]" required>' +
      '</td>' +
      '<td class="wtm_100">' +
      '<input type="text" class="form-control form-control-sm dispatch_item_inv_no" name="input[' + i + '][dispatch_item_inv_no]" required>' +
      '</td>' +
      '<td class="wtm_100">' +
      '<div class="input-group date" id="dispatch_item_date_' + i + '" data-target-input="nearest">' +
      '<input type="text" class="form-control form-control-sm datetimepicker-input"  name="input[' + i + '][dispatch_item_date]" value="" data-target="#dispatch_item_date_' + i + '" data-toggle="datetimepicker" required>' +
      '</div>' +
      '</td>' +
      '<td class="wtm_100">' +
      '<input type="number" class="form-control form-control-sm dispatch_item_pending_qty" name="input[' + i + '][dispatch_item_pending_qty]" required>' +
      '</td>' +
      '<td class="select_sm wtm_150">' +
      '<select class="form-control select2 form-control-sm remark_id w-100" name="input[' + i + '][remark_id]" data-placeholder="Select DRG No" required>' +
      '<option value="">Select Remark</option>' +
      '<?php if (isset($remark_list)) {
          foreach ($remark_list as $remark_list2) { ?>' +
      '<option value="<?php echo $remark_list2->remark_id; ?>" <?php if ($remark_list2->remark_status == 0) {
                                                                  echo ' disabled';
                                                                } ?> ><?php echo $remark_list2->remark_name; ?></option>' +
      '<?php }
        } ?>' +
      '</select>' +
      '</td>' +
      '<td class="wt_50"><a class="rem_row"><i class="fa fa-trash text-danger"></i></a></td>' +
      '</tr>';
    $('#myTable1').append(row);
    $('.select2').select2();

    $('#dispatch_item_date_' + i + '').datetimepicker({
      format: 'DD-MM-Y'
    });

    // var party_id =  $('#party_id').find("option:selected").val();
    // $.ajax({
    //   url:'<?php echo base_url(); ?>Master/get_item_list_by_party',
    //   type: 'POST',
    //   data: {"party_id":party_id},
    //   context: this,
    //   success: function(result){
    //     $('#item_id_'+i+'').html(result);
    //   }
    // });
  });

  $('#myTable1').on('click', '.rem_row', function() {
    $(this).closest('tr').remove();
    final_calculation();
  });

  function dispatchQty(element) {
    var poQty = parseFloat($("#po_qty").val()) || 0;
    var currentQty = parseFloat($(element).val()) || 0;
    if (currentQty > poQty) {
      alert('Dispatch Qty cannot be greater than PO Qty');
      $(element).val(poQty);
      dispatchQty(element);

      return;
    }
    console.log("477");

    var inputName = $(element).attr('name');
    var index = inputName.match(/\[(\d+)\]/)[1];

    $("input[name='input[" + index + "][dispatch_item_pending_qty]']")
      .val(poQty - currentQty);
  }
</script>