@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- DataTable -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- <sript src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
     <!-- SweetAlert2 -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script> -->

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.14/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.14/dist/js/select2.min.js"></script> -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Referrals</h1>
                </div>

                <div class="panel-body">
                    <div>@include('partials.filterReferrals') @include('partials.createReferralButton')</div>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div>
                                    <h3>Additional Features:</h3>
                                    <h6>Copy column data to clipboard: <b>double click the column</b></h6>
                                    <h6>Search by column: <b>ctrl+click the column</b></h6>
                                    @if($filters && count($filters) > 0)
                                    <h3>Active Filter(s)</h3>
                                    @foreach($filters as $fk => $fv)
                                <p><span>{{$fk}}</span> : <b>{{$fv}}</b></p>
                            @endforeach
                        @endif
                    </div>
                    <table class="table table-striped table-hover table-outlined" id="refTable">
                        <thead>
                            <!-- <td>Country</td> -->
                            <td>Reference No</td>
                            <td>Organisation</td>
                            <td>Address</td>
                            <td>Facility</td>
                            <td>Provider</td>
                            <td>Pills</td>
                            <td>Type of Service</td>
                            <td>Note</td>
                            <td>Womens Evaluation</td>
                            <td>Code & Comments</td>
                        </thead>
                        <script>
                            refComments = {};
                            currentUser = {};
                            currentUser.name = "{{Auth::user()->name}}";
                        </script>
                        @foreach($referrals as $referral)
                        @php
                        
                        $comments = [];
                        $comments=App\Comment::where('referral_id','=', $referral->id)->get();
                        @endphp
                        <script>
                            refID = 0;
                            refComments["{{ '_'.$referral->reference_no }}"] = [
                                @foreach($comments as $comment)
                                {{"{"}}
                                id : {{$comment->id}},
                                name : "{{(\App\User::find($comment->user_id)->first()->name)}}",
                                comment : "{{$comment->comment}}"
                                {{"},"}}
                                @endforeach
                            ];
                        </script>
                        <tr>
                            <td class='copy' data-type="reference_no">{{ $referral->reference_no }} </td>
                            <td class='copy' data-type="organisation">{{ $referral->organisation }} </td>
                            <td>
                                <p><b data-type="country">Coun:</b> <span class='copy'>{{ $referral->country }}</span></p>
                                <p><b data-type="province">Prov:</b> <span class='copy'>{{ $referral->province }}</span></p>
                                <p><b data-type="district">Dist:</b> <span class='copy'>{{ $referral->district }}</span></p>
                                <p><b data-type="city">City:</b> <span class='copy'>{{ $referral->city }}</span></p>
                                <p><b data-type="street_address">Addr:</b> <span class='copy'>{{ $referral->street_address }}</span></p>
                                <p><b data-type="gps_location">GPS: </b><span class='copy'>{{ $referral->gps_location }}</span></p>
                            </td>
                            <!-- <td>
                                <p><b>Name:</b> <span class='copy'>{{ $referral->facility_name }}</span></p>
                                <p><b>Type:</b> <span class='copy'>{{ $referral->facility_type }}</span></p>
                                <p><b>Web:</b> <span class='copy'>{{ $referral->website }}</span></p>
                            </td>
                            <td>
                                <p><b>Name:</b> <span class='copy'>{{ $referral->provider_name }}</span></p>
                                <p><b>Pos:</b> <span class='copy'>{{ $referral->position }}</span></p>
                                <p><b>Phon:</b> <span class='copy'>{{ $referral->phone }}</span></p>
                                <p><b>Mail:</b> <span class='copy'>{{ $referral->email }}</span></p>
                            </td> -->
                            <td>
                                <p><b data-type="facility_name">Name:</b> <span class='copy'>{{ $referral->facility_name }}</span></p>
                                <p><b data-type="facility_type">Type:</b> <span class='copy'>{{ $referral->facility_type }}</span></p>
                                <p><b data-type="phone">Phone:</b> <span class='copy'>{{ $referral->phone }}</span></p>
                                <p><b data-type="email">Mail:</b> <span class='copy'>{{ $referral->email }}</span></p>
                                <p><b data-type="website">Web:</b> <span class='copy'>{{ $referral->website }}</span></p>
                            </td>
                            <td>
                                <p><b data-type="provider_name">Name:</b> <span class='copy'>{{ $referral->provider_name }}</span></p>
                                <p><b data-type="position">Pos:</b> <span class='copy'>{{ $referral->position }}</span></p>
                            </td>
                            <td class='copy' data-type="pills_available">{{ $referral->pills_available }}</td>
                            <td class='copy'  data-type="type_of_service">{{ $referral->type_of_service }} </td>
                            <td class='copy'  data-type="note">{{ $referral->note }} </td>
                            <td class='copy'  data-type="womens_evaluation">{{ $referral->womens_evaluation }} </td>
                            <td  class="copy expandable">
                                <p><b data-type="code_to_use">Code:</b> <span class='copy'>{{ $referral->code_to_use }}</span></p>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#showCommentModal" id="show_{{ $referral->reference_no }}" onclick="window.referral_id = {{$referral->id}}; openShowCommentModal('{{ $referral->reference_no }}')">Open Comments</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                            <script>
                                let table = new DataTable('#refTable', {
                                    paging: false,
                                    "searching": false
                                });
                                
                            </script>
                <div class="panel-footer">
                    {{ $referrals->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Show-Comment-Modal -->
<div class="modal fade" id="showCommentModal" tabindex="-1" role="dialog" aria-labelledby="showCommentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-comment-title">Comments on referral #<span class="show-comment-title-span"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#commentModal" onclick="openAddCommentModal()">Add</button>
                <h3>Comments</h3>
                <ul id="comments-ul">
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeShowCommentModal" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add-Comment-Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add comment to Referral #<span id="comment-title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="comment-form" action="/add-comment" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="referral_id" value="">
                    <div class="form-group">
                        <label for="comment">Your comment </label>
                        <input type="text" id="comment" name="comment" class="form-control" placeholder="Comment.." />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="saveComment()">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    /**
     * Prepare comment create modal
     */
    const openAddCommentModal = () => {
        $("#comment-title").text(refID);
        $("#comment").val("");
    };
    /**
     * Prepare comment view modal
     */
    const openShowCommentModal = (refId) => {
        $(".show-comment-title-span")[0].innerHTML = refId;
        refID = refId;
        $("#comments-ul").html(' <span>Loading comments...</span>')
        let html = "";
        let comments = refComments[('_'+refId)];
        if(comments.length >=1){
            comments.forEach((e, i)=> {
                if(!e.hasOwnProperty("deleted")) html+=`<li id="comment_${e.id}">${e.comment} <small style="float:right;"> <a  data-index="${e.id}" href="javascript:deleteComment(${e.id}, this)" class="text text-red">Delete</a> </small> <small style="float:right;">by ${e.name}</small> </li>`
            })
            $("#comments-ul").html(html);
        }
        else  {
            $("#comments-ul").html("<span>No comments yet, use the button above to add a new comment</span>");
        }
        refID = refId;
    };

    /**
     * Store comment via AJAX request
     */
    const saveComment = () => {
        const csrf = $("meta[name=csrf-token]").attr("content");
        $.post("{{ route('add-comment') }}", {
            _token: csrf,
            user_id: "{{Auth::user()->id}}",
            referral_id: window.referral_id,
            user_id: "{{ Auth::User()->id }}",
            comment: $("#comment").val()
        }, (response) => {
            if(response.statusCode == 1){
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                refComments['_'+refID].push(response.data);
                refreshComment();
            }
            
        });
    };

    /**
     * Delete comment by `id` via AJAx request
     */
    const deleteComment = (id) => {
        let url = "/delete-comment/"+id;
        $.getJSON(url, (data)=>{
            if(data.statusCode == 1){
                 Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                let comment = refComments['_'+refID];
                let commentId = 0;
                comment.forEach((e, i) => {
                    if(e.id == id) commentId = i;
                })
                $("#comment_"+id).remove();
                comment[commentId].deleted = true;
            }
            else {
                toastr.error(data.message ?? "OK!");
            }
            refreshComment();
        })
    };

    /**
     * Close modals and reopen them for fresh data
     */
    const refreshComment = () => {
        openShowCommentModal(refID);
    };
</script>
@endsection