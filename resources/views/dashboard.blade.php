@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" id="root">
        <div class="bg-white shadow rounded p-2">
            <p>Create a Post:</p>
            <textarea class="w-full h-20 border-solid border-gray-500 border shadow rounded" maxlength="500" id="input" v-model="newPostText" style="resize: none;"></textarea>
            <div class="relative py-2">
                <button class="bg-white border-solid border-gray-500 border shadow rounded px-5 py-2" @click="createPost">Post</button>
                <input class="absolute right-0 border-2 border-dotted border-gray-500 rounded p-2" type="file" accept="image/jpeg,image/png" id="file" ref="file" @change="previewImage">
            </div>
            
        </div>

        <hr class="p-1"/>

        <ul> <li v-for="post in posts">
            <div class="bg-white shadow rounded p-2">
                <div class="relative">
                    <p class="aboslute font-semibold">@{{ post.name }}</p>
                    <p class="absolute top-0 right-0 text-xs">@{{ post.date_posted }}</p>
                </div>
                <hr class="p-1"/>  
                <p>@{{ post.text }}</p>
                <div v-if="post.image_path" class="py-2">
                    <img :src="'{{ route('api.images.specific', '') }}/' + post.image_path" alt="" class="shadow rounded"/>
                </div>
                <hr class="py-1"/>
                <div class="relative py-1">
                <a class="bg-white border-solid border-gray-500 border shadow rounded px-3 py-1 text-xs" :href="/post/ + post.id">View Comments</a>
                </div>
            </div>
            <hr class="p-1"/>
        </li> </ul> 
    </div>

    <script>
        var app = new Vue({
            el: "#root",
            data: {
                posts: [],
                newPostText: '',
                newPostImage: '',
            },
            methods: {
                createPost:function() {
                    let formData = new FormData();
                    
                    formData.append('user_id', {{ Auth::id() }});
                    formData.append('text', this.newPostText);

                    if (this.newPostImage) {
                        formData.append('image', this.newPostImage);
                    }

                    axios.post("{{route('api.posts.store')}}",
                        formData,
                        {
                            headers: {'Content-Type': 'multipart/form-data'}
                        }
                    )
                    .then(response=>{
                        this.posts.push(response.data);
                        this.newPostText = '';
                    })
                    .catch(response=>{
                    console.log(response);
                    })
                },

                previewImage(event) {
                    this.newPostImage = event.target.files[0];
                    console.log(this.newPostImage);
                }

            },
            mounted() {
                
                axios.get("{{route('api.posts.index')}}")
                .then(response=>{
                    this.posts = response.data;
                })
                .catch(response=>{
                    console.log(response);
                })
            }
        });
    </script>
@endsection