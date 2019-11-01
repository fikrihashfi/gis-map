@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3 style="text-align:center;">Add Data Gempa</h3>

                    <br>
                
                    <form action="map/add" method="post">
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
                        <br>
                        <button type="submit" class="btn btn-primary" >Simpan Data</button>
                    </form>
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
