@extends('layouts.app')

<style> 
 body {
        color: #566787;
		background: #f5f5f5;
		font-family: 'Varela Round', sans-serif;
		font-size: 13px;
	}
	.table-wrapper {
        background: #fff;
        padding: 20px 25px;
        margin: 30px 0;
		border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
	.table-title {        
		padding-bottom: 15px;
		background: #435d7d;
		color: #fff;
		padding: 16px 30px;
		margin: -20px -25px 10px;
		border-radius: 3px 3px 0 0;
    }
    .table-title h2 {
		margin: 5px 0 0;
		font-size: 24px;
	}
	.table-title .btn-group {
		float: right;
	}
	.table-title .btn {
		color: #fff;
		float: right;
		font-size: 13px;
		border: none;
		min-width: 50px;
		border-radius: 2px;
		border: none;
		outline: none !important;
		margin-left: 10px;
	}
	.table-title .btn i {
		float: left;
		font-size: 21px;
		margin-right: 5px;
	}
	.table-title .btn span {
		float: left;
		margin-top: 2px;
	}
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
		padding: 12px 15px;
		vertical-align: middle;
    }
	table.table tr th:first-child {
		width: 60px;
	}
	table.table tr th:last-child {
		width: 100px;
	}
    table.table-striped tbody tr:nth-of-type(odd) {
    	background-color: #fcfcfc;
	}
	table.table-striped.table-hover tbody tr:hover {
		background: #f5f5f5;
	}
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }	
    table.table td:last-child i {
		opacity: 0.9;
		font-size: 22px;
        margin: 0 5px;
    }
	table.table td a {
		font-weight: bold;
		color: #566787;
		display: inline-block;
		text-decoration: none;
		outline: none !important;
	}
	table.table td a:hover {
		color: #2196F3;
	}
	table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #F44336;
    }
    table.table td i {
        font-size: 19px;
    }
	table.table .avatar {
		border-radius: 50%;
		vertical-align: middle;
		margin-right: 10px;
	}
    .pagination {
        float: right;
        margin: 0 0 5px;
    }
    .pagination li a {
        border: none;
        font-size: 13px;
        min-width: 30px;
        min-height: 30px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 2px !important;
        text-align: center;
        padding: 0 6px;
    }
    .pagination li a:hover {
        color: #666;
    }	
    .pagination li.active a, .pagination li.active a.page-link {
        background: #03A9F4;
    }
    .pagination li.active a:hover {        
        background: #0397d6;
    }
	.pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }    
	/* Custom checkbox */
	.custom-checkbox {
		position: relative;
	}
	.custom-checkbox input[type="checkbox"] {    
		opacity: 0;
		position: absolute;
		margin: 5px 0 0 3px;
		z-index: 9;
	}
	.custom-checkbox label:before{
		width: 18px;
		height: 18px;
	}
	.custom-checkbox label:before {
		content: '';
		margin-right: 10px;
		display: inline-block;
		vertical-align: text-top;
		background: white;
		border: 1px solid #bbb;
		border-radius: 2px;
		box-sizing: border-box;
		z-index: 2;
	}
	.custom-checkbox input[type="checkbox"]:checked + label:after {
		content: '';
		position: absolute;
		left: 6px;
		top: 3px;
		width: 6px;
		height: 11px;
		border: solid #000;
		border-width: 0 3px 3px 0;
		transform: inherit;
		z-index: 3;
		transform: rotateZ(45deg);
	}
	.custom-checkbox input[type="checkbox"]:checked + label:before {
		border-color: #03A9F4;
		background: #03A9F4;
	}
	.custom-checkbox input[type="checkbox"]:checked + label:after {
		border-color: #fff;
	}
	.custom-checkbox input[type="checkbox"]:disabled + label:before {
		color: #b8b8b8;
		cursor: auto;
		box-shadow: none;
		background: #ddd;
	}
	/* Modal styles */
	.modal .modal-dialog {
		max-width: 400px;
	}
	.modal .modal-header, .modal .modal-body, .modal .modal-footer {
		padding: 20px 30px;
	}
	.modal .modal-content {
		border-radius: 3px;
	}
	.modal .modal-footer {
		background: #ecf0f1;
		border-radius: 0 0 3px 3px;
	}
    .modal .modal-title {
        display: inline-block;
    }
	.modal .form-control {
		border-radius: 2px;
		box-shadow: none;
		border-color: #dddddd;
	}
	.modal textarea.form-control {
		resize: vertical;
	}
	.modal .btn {
		border-radius: 2px;
		min-width: 100px;
	}	
	.modal form label {
		font-weight: normal;
	}	
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3 style="text-align:center;">Data Gempa</h3>

                      <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>Manage <b>Gempa</b></h2>
                            </div>
                            <div class="col-sm-6">
                                <a href="#addGempaModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Data Gempa</span></a>
                                <!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						 -->
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <!-- <th>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="selectAll">
                                        <label for="selectAll"></label>
                                    </span>
                                </th> -->
                                <th>magnitude</th>
                                <th>audio link</th>
                                <th>video link</th>
                                <th>kedalaman</th>
                                <th>lintang</th>
                                <th>bujur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($gempa as $g)
                            <tr>
                                <!-- <td>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="checkbox1" name="options[]" value="1">
                                        <label for="checkbox1"></label>
                                    </span>
                                </td> -->
                                <td>{{ $g->Magnitude }}</td>
                                <td>{{ $g->Audio_Link }}</td>
                                <td>{{ $g->Video_Link }}</td>
                                <td>{{ $g->Kedalaman }}</td>
                                <td>{{ $g->Lintang }}</td>
                                <td>{{ $g->Bujur }}</td>
                                <td>
                                    <a href="#editGempaModal{{$g->id}}" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                    <a href="#deleteGempaModal{{$g->id}}" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                </td>
                            </tr>
                        @endforeach          
                        </tbody>
                    </table>
                    <!-- <div class="clearfix">
                        <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                        <ul class="pagination">
                            <li class="page-item disabled"><a href="#">Previous</a></li>
                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                            <li class="page-item active"><a href="#" class="page-link">3</a></li>
                            <li class="page-item"><a href="#" class="page-link">4</a></li>
                            <li class="page-item"><a href="#" class="page-link">5</a></li>
                            <li class="page-item"><a href="#" class="page-link">Next</a></li>
                        </ul>
                    </div> -->
                </div>
            </div>
            <!-- Edit Modal HTML -->
            <div id="addGempaModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="map/add" method="post">
                            <div class="modal-header">						
                                <h4 class="modal-title">Add Gempa</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">					
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col">
                                        <label for="inputLintang">Lintang :</label>   
                                        <input type="text" class="form-control" name="Lintang" required="required" placeholder="ex: -6.554123">
                                    </div>
                                    <div class="col">
                                        <label for="inputBujur">Bujur :</label>   
                                        <input type="text" class="form-control" name="Bujur" required="required" placeholder="ex: 106.823531">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <label for="inputKedalaman">Kedalaman (Km) :</label>
                                        <input type="number" step=0.01 class="form-control" name="Kedalaman" required="required" placeholder="ex: 1.55">
                                    </div>
                                    <div class="col">
                                        <label for="inputMagnitudo">Magnitude (SR) :</label>        
                                        <input type="number" step=0.01 class="form-control" name="Magnitude" required="required" placeholder="ex: 4.53">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <label for="inputAudio">Audio Link :</label>
                                        <input type="text"  class="form-control" name="Audio_Link" required="required" placeholder="ex: https://a.com/a.mp3">
                                    </div>
                                    <div class="col">
                                        <label for="inputVideo">Video Link (embed) :</label>        
                                        <input type="text" class="form-control" name="Video_Link" required="required" placeholder="ex: https://www.youtube.com/embed/QON-DcF67iE">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input type="submit" class="btn btn-success" value="Add">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Modal HTML -->
            @foreach($gempa as $g)
            <div id="editGempaModal{{$g->id}}" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="map/edit" method="post">
                            <div class="modal-header">						
                                <h4 class="modal-title">Edit Employee</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">					
                            {{ csrf_field() }}
                            <input type="text" value="{{$g->id}}" class="form-control" name="id" required="required" placeholder="id" hidden>
                                <div class="row">
                                    <div class="col">
                                        <label for="inputLintang">Lintang :</label>   
                                        <input type="text" value="{{$g->Lintang}}" class="form-control" name="Lintang" required="required" placeholder="ex: -6.554123">
                                    </div>
                                    <div class="col">
                                        <label for="inputBujur">Bujur :</label>   
                                        <input type="text" value="{{$g->Bujur}}" class="form-control" name="Bujur" required="required" placeholder="ex: 106.823531">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <label for="inputKedalaman">Kedalaman (Km) :</label>
                                        <input type="number" value="{{$g->Kedalaman}}" step=0.01 class="form-control" name="Kedalaman" required="required" placeholder="ex: 1.55">
                                    </div>
                                    <div class="col">
                                        <label for="inputMagnitudo">Magnitude (SR) :</label>        
                                        <input type="number" value="{{$g->Magnitude}}" step=0.01 class="form-control" name="Magnitude" required="required" placeholder="ex: 4.53">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <label for="inputAudio">Audio Link :</label>
                                        <input type="text" value="{{$g->Audio_Link}}"  class="form-control" name="Audio_Link" required="required" placeholder="ex: https://a.com/a.mp3">
                                    </div>
                                    <div class="col">
                                        <label for="inputVideo">Video Link (embed) :</label>        
                                        <input type="text" value="{{$g->Video_Link}}" class="form-control" name="Video_Link" required="required" placeholder="ex: https://www.youtube.com/embed/QON-DcF67iE">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input type="submit" class="btn btn-info" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Delete Modal HTML -->
            <div id="deleteGempaModal{{$g->id}}" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="map/delete/{{$g->id}}" method="get">
                            <div class="modal-header">						
                                <h4 class="modal-title">Delete Data Gempa</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">					
                                <p>Are you sure you want to delete these Records?</p>
                                <p class="text-warning"><small>This action cannot be undone.</small></p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

<!-- <script type="text/javascript">
$(document).ready(function(){
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
});
</script> -->
