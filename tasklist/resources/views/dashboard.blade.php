<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="flex">
                    <div class="flex-auto text-2xl mb-4">Lista de Tarefas</div>

                    <div class="flex-auto text-right mt-2">
                        <a href="/task" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Adicionar nova Tarefa</a>
                    </div>
                    <div class="flex-auto text-right mt-2">
                        <select class="form-control" name="select" onchange="location = this.value;">
                            <option value="">-----</option>
                            <option value="/dashboard/concluded">
                                Apenas concluídas</option>
                            <option value="/dashboard/unconcluded">
                                Apenas por concluir</option>
                        </select>
                    </div>
                </div>
                <table class="w-full text-md rounded mb-4">
                    <thead>
                    <tr class="border-b">
                        <th class="text-left p-3 px-5">Tarefa</th>
                        <th class="text-left p-3 px-5">Ações</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr class="border-b {{$task->is_concluded ? 'hover:bg-green-100' : 'hover:bg-orange-100'}}">
                            <td class="p-3 px-5">
                                <span style="float:right;"><i class="{{$task->is_concluded ? 'fa fa-check-circle' : 'fa fa-times-circle'}}"></i></span>
                                {{$task->name}}
                            </td>
                            <td class="p-3 px-5">
                                @if(!$task->is_concluded)
                                    <a href="/task/{{$task->id}}" name="edit" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Editar</a>
                                    <form action="/task/{{$task->id}}/conclude" class="inline-block">
                                        <button type="submit" name="conclude" formmethod="POST" class="text-sm bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Concluir Tarefa</button>
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                                <form action="/task/{{$task->id}}" class="inline-block">
                                    <button type="submit" name="delete" formmethod="POST" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Apagar</button>
                                    {{ csrf_field() }}
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
