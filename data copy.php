<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';

// Fetch user data if needed
// Example: $result = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."'");

?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Tables</h1>
          <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Scan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="data-table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 3</th>
                        <th>Column 4</th>
                        <th>Column 5</th>
                        <th>Column 6</th>
                        <th>Column 7</th>
                        <th>Column 8</th>
                        <th>Column 9</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-form">
                        <input type="hidden" id="edit-id">
                        <div class="form-group">
                            <label for="edit-col1">Column 1</label>
                            <input type="text" class="form-control" id="edit-col1" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-col2">Column 2</label>
                            <input type="text" class="form-control" id="edit-col2" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-col3">Column 3</label>
                            <input type="text" class="form-control" id="edit-col3" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-col4">Column 4</label>
                            <input type="text" class="form-control" id="edit-col4" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-date">Date</label>
                            <input type="date" class="form-control" id="edit-date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-col6">Column 6</label>
                            <input type="text" class="form-control" id="edit-col6" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-col7">Column 7</label>
                            <input type="text" class="form-control" id="edit-col7" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-col8">Column 8</label>
                            <input type="text" class="form-control" id="edit-col8" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-col9">Column 9</label>
                            <input type="text" class="form-control" id="edit-col9" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script> <!-- FontAwesome JS -->
    <script>
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                "ajax": {
                    "url": "fetch_data.php",
                    "dataSrc": "data",
                    "data": function(d) {
                        d.date = $('#date-filter').val();
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "col1" },
                    { "data": "col2" },
                    { "data": "col3" },
                    { "data": "col4" },
                    { "data": "date" },
                    { "data": "col6" },
                    { "data": "col7" },
                    { "data": "col8" },
                    { "data": "col9" },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return `
                                <i class="fa fa-edit action-icon" onclick="editRow(${row.id})"></i>
                                <i class="fa fa-trash action-icon" onclick="deleteRow(${row.id})"></i>
                                <i class="fa fa-check action-icon btn-success" onclick="acceptRow(${row.id})"></i>
                            `;
                        }
                    }
                ]
            });

            $('#date-filter').on('change', function() {
                table.ajax.reload();
            });

            $('#edit-form').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit-id').val();
                var col1 = $('#edit-col1').val();
                var col2 = $('#edit-col2').val();
                var col3 = $('#edit-col3').val();
                var col4 = $('#edit-col4').val();
                var date = $('#edit-date').val();
                var col6 = $('#edit-col6').val();
                var col7 = $('#edit-col7').val();
                var col8 = $('#edit-col8').val();
                var col9 = $('#edit-col9').val();

                $.ajax({
                    url: 'edit_data.php',
                    type: 'POST',
                    data: {
                        id: id,
                        col1: col1,
                        col2: col2,
                        col3: col3,
                        col4: col4,
                        date: date,
                        col6: col6,
                        col7: col7,
                        col8: col8,
                        col9: col9
                    },
                    success: function(response) {
                        $('#editModal').modal('hide');
                        table.ajax.reload();
                    }
                });
            });
        });

        function editRow(id) {
            $.ajax({
                url: 'get_data.php',
                type: 'GET',
                data: { id: id },
                success: function(data) {
                    var row = JSON.parse(data);
                    $('#edit-id').val(row.id);
                    $('#edit-col1').val(row.col1);
                    $('#edit-col2').val(row.col2);
                    $('#edit-col3').val(row.col3);
                    $('#edit-col4').val(row.col4);
                    $('#edit-date').val(row.date);
                    $('#edit-col6').val(row.col6);
                    $('#edit-col7').val(row.col7);
                    $('#edit-col8').val(row.col8);
                    $('#edit-col9').val(row.col9);
                    $('#editModal').modal('show');
                }
            });
        }

        function deleteRow(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: 'delete_data.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        $('#data-table').DataTable().ajax.reload();
                    }
                });
            }
        }

        function acceptRow(id) {
            $.ajax({
                url: 'accept_data.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    $('#data-table').DataTable().ajax.reload();
                }
            });
        }
    </script>
<?php 
include 'pages/footer.php';
?>