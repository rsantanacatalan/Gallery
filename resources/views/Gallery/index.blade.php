@extends('layouts.app')

@section('content')
<div class="flex flex-row justify-between ">
    <div class="flex">
        <img class="pr-5" src="/logo/my_unsplash_logo.svg" alt="">
        <form action="/" method="get">
            
            <input id="search" value="{{Request::get('name')}}" name="name" class="border-2 rounded-xl px-4 py-4 focus:outline-none focus:border-green-500" type="text" name="" id="" placeholder="Search by name">
        </form>
    </div>
    <button id="open-modal" class="bg-green-500 px-6 py-4 rounded-xl shadow-md text-white font-bold hover:bg-green-400">Add a photo</button>
</div>
<div class="masonry-3-col pt-14">
@if($photos->count())
    @foreach($photos as $photo)
    
        <div class="flex relative picture hover:opacity-95 break-inside mb-8 mx-2">
            <form id="formDelete{{$photo->id}}" action="{{ route('delete', $photo) }}" method="post">
                @csrf
                @method('DELETE')
            </form>
            <button data-id="{{$photo->id}}" class="delete absolute top-4 right-2 border-2 text-red-600 border-red-600 py-1 px-4 rounded-full hidden">delete</button>
            <img src="{{$photo->url}}" title="asasdasd" class="rounded-xl">
            <h1 class="absolute bottom-8 left-4 text-white font-bold tracking-wider hidden">{{$photo->label}}</h1>
        </div>
    
    @endforeach
@else
    <p>There are no pictures</p>
@endif

 <!-- modal add -->
 <form id="add" action="{{ route('add')}}" method="post">
    @csrf
    <div id="modal" class="fixed hidden inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full " id="my-modal">
        <div  class="relative top-20 mx-auto p-7 border w-1/2 shadow-lg rounded-xl bg-white ">
            <div class="flex flex-col">
                <h1 class="text-xl">Add a new photo</h1>
                <label class="text-sm text-gray-700 pt-5 pb-3">Label</label>
                <input id="label" type="text" name="label" class="border-2 rounded-xl px-4 py-3 focus:outline-none border-gray-400 focus:border-gray-500 ">
                @error('label') 
                <div class="text-sm text-red-500">
                    {{ $message}}
                </div>  
                @enderror
                <label class="text-sm text-gray-700 pt-6 pb-3">Photo URL</label>
                <input id="url" type="text" name="url" class="border-2 rounded-xl px-4 py-3 focus:outline-none border-gray-400 focus:border-gray-500 "  >
                @error('url') 
                <div class="text-sm text-red-500">
                    {{ $message}}
                </div>  
                @enderror
            </div>
            <div class="flex flex-row justify-end pt-6 gap-4">
                <button type="button" id="Cancel" class="px-6 py-3 text-gray-400 font-bold">Cancel</button>
                <button id="submit" type="submit" class="bg-green-500 px-6 py-3 rounded-xl shadow-md text-white font-bold hover:bg-green-400">Submit</button>
            </div>
        </div>
    </div>
</form>

<!-- modal delete -->
<div id="modalDelete" class="fixed hidden inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full " id="my-modalDelete">
    <div  class="relative top-20 mx-auto p-7 border w-1/2 shadow-lg rounded-xl bg-white ">
        <div class="flex flex-col">
            <h1 class="text-xl">Are you sure?</h1>
        </div>
        <div class="flex flex-row justify-end pt-6 gap-4">
            <button type="button" id="CancelDelete" class="px-6 py-3  text-gray-400 font-bold">Cancel</button>
            <button type="submit" id="SubmitDelete" class="bg-green-500 px-6 py-3 rounded-xl shadow-md text-white font-bold hover:bg-green-400">Delete</button>
        </div>
    </div>
</div>


<script>

$(document).ready(function(){
  $('.picture').hover(
      function(){
        $(this).children('button').show();
        $(this).children('h1').show();
    }, function(){
        $(this).children('button').hide();
        $(this).children('h1').hide();
    });

    $('#open-modal').click(function(){
        $('#modal').css("display","block");
    });

    $('#submit').click(function(){
        var label = $('#label').val();
        var url = $('#url').val();
        if(label == "" ){
            if(url == ""){
                $("#add").submit(function(e){
                    e.preventDefault();
                });
            }
        }
    });
    $('#Cancel').click(function(){
        $('#modal').css("display","none");
    });

    var id;
    $('.delete').click(function(){
        id = $(this).data('id');
        console.log(id);
        $('#modalDelete').css("display","block");
    });


    $('#SubmitDelete').click(function(){
        console.log(id);
        $("#formDelete"+id).submit();
    });

    $('#CancelDelete').click(function(){
        $('#modalDelete').css("display","none");
    });

    $('#search').on('keyup', function(e){
        if (e.key === 'Enter' || e.keyCode === 13) {
            console.log("hola");
        }
    });
});
    
</script>
@endsection