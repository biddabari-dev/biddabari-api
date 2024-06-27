<style>
    .correct-ans-bg { background-color: #B2DB9A}
    .ranking-table td {font-size: 20px}
    .ranking-table th {font-size: 24px}
</style>

<div class="row">
    <div class="section-title ">
        <div class="card">
            <div class="">
                <h2 class="text-center"> Participate Students</h2>
                <hr class="w-25 mx-auto bg-danger"/>
            </div>
            <div class="card-body">
                <div class="row ">

                    <div class="card card-body">
                        <table class="table ranking-table table-borderless" id="file-datatable">
                            <thead>
                            <tr>
                                <th>RANK</th>
                                <th>NAME</th>
                                <th>MARK</th>
                                <th>Provided Ans</th>
                                <th>Right Ans</th>
                                <th>Wrong Ans</th>
                                <th>DURATION</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($xmResults as $key => $courseExamResult)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $courseExamResult->user->name }}</td>
                                        <td>{{ $courseExamResult->result_mark ?? 0 }}</td>
                                        <td>{{ $courseExamResult->total_provided_ans ?? 0 }}</td>
                                        <td>{{ $courseExamResult->total_right_ans ?? 0 }}</td>
                                        <td>{{ $courseExamResult->total_wrong_ans ?? 0 }}</td>
                                        <td>{{ \Carbon\CarbonInterval::seconds($courseExamResult->required_time)->cascade()->forHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
