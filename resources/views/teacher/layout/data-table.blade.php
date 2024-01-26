 <div class="col-md-12 col-sm-12 ">
    <div class="x_content">
        <div class="row">
            <div class="col-sm-12">
            <div class="card-box table-responsive">
                <table id="{{$table_id}}" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                   <thead>
                        <tr>
                            @foreach($thead as $th)
                                <th>{{$th}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
