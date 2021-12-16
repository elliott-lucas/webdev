@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('View Post') }}
    </h2>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8" id="root">
        <div class="bg-white shadow rounded p-2">
            <div class="relative">
                <p class="aboslute font-semibold">@{{ post.name }}</p>
                <p class="absolute inset-y-0 right-0 text-xs">@{{ post.date_posted }}</p>
            </div>
            <hr class="py-1"/>
            <p v-if="!showEditView">@{{ post.text }}</p>
            <input v-if="post.user_id == {{Auth::id()}} && showEditView" type="text" maxlength="500" id="input" v-model="newPostText">
            <div v-if="post.image_path" class="py-2">
                <img :src="'{{ route('api.images.specific', '') }}/' + post.image_path" alt="" class="shadow rounded"/>
            </div>
            <hr v-if="post.user_id == {{Auth::id()}}" class="py-1"/>
            <button v-if="post.user_id == {{Auth::id()}} && !showEditView" class="bg-white border-solid border-gray-500 border shadow rounded px-3 py-1 text-xs" @click="toggleEditView">Edit</button>
            <button v-if="post.user_id == {{Auth::id()}} && showEditView" class="bg-white border-solid border-gray-500 border shadow rounded px-3 py-1 text-xs" @click="editPost">Save</button>
        </div>

        <hr class="p-1"/>

        <div class="py-2">
            <h1 class="font-semibold text-xl text-gray-800">Comments</h1>
            <ul> 
                <li v-for="comment in comments"> 
                    <div class="bg-white shadow rounded p-2">
                        <div class="relative">
                            <p class="aboslute font-semibold">@{{ comment.name }}</p>
                            <p class="absolute inset-y-0 right-0 text-xs">@{{ comment.date_posted }}</p>
                        </div>
                        <hr class="p-1"/>   
                        <p>@{{ comment.text }}</p>
                    </div>
                    <hr class="p-1"/>
                </li> 
            </ul>

            <div class="bg-white shadow rounded p-2">
                <p>Add a Comment:</p>
                <textarea class="w-full h-20 border-solid border-gray-500 border shadow rounded" maxlength="500" id="input" v-model="newCommentText" style="resize: none;"></textarea>
                <div class="pb-2"></div>
                <button class="bg-white border-solid border-gray-500 border shadow rounded px-5 py-2" @click="createComment">Post</button>
            </div>
        </div>



    </div>

    <script>
        var app = new Vue({
            el: "#root",
            data: {
                post: '',
                comments: [],
                newCommentText: '',
                newPostText: '',
                showEditView: false,
            },
            methods: {
                createComment:function() {
                    axios.post("{{route('api.comments.store')}}",
                    {
                        text: this.newCommentText,
                        post_id: {{ $id }},
                        user_id: {{ Auth::id() }},
                    })
                    .then(response=>{
                        this.comments.push(response.data);
                        this.newCommentText = '';
                    })
                    .catch(response=>{
                    console.log(response);
                    })
                },

                toggleEditView:function() {
                    this.showEditView = !this.showEditView;
                    this.newPostText = this.post.text;
                },

                editPost:function() {
                    console.log(this.newPostText);
                    axios.post("{{route('api.posts.edit')}}",
                    {
                        text: this.newPostText,
                        post_id: {{ $id }},
                        user_id: {{ Auth::id() }},
                    })
                    .then(response=>{
                        this.post.text = response.data['text'];
                        this.newCommentText = '';
                        this.showEditView = !this.showEditView;
                    })
                    .catch(response=>{
                    console.log(response);
                    })
                }
            },
            mounted() {
                
                axios.get("{{route('api.posts.specific', $id)}}")
                .then(response=>{
                    this.post = response.data;
                    console.log(this.post.name);
                    axios.get("{{route('api.comments.specific', $id)}}")
                    .then(response=>{
                        this.comments = response.data;

                    })
                    .catch(response=>{
                        console.log(response);
                    })
                })
                .catch(response=>{
                    console.log(response);
                })
            }

            
        });
    </script>
    
@endsection