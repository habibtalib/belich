{{-- <belich::model
        :columns="['id', 'name', 'email']"
        :model="\App\User"
        id="tool-model" //this fields can be empty
        width="w-2/3" //this fields can be empty
        limit="10" //this fields can be empty
    ></belich::model> --}}

{{-- Model to table --}}
@isset($columns, $model)
    <div id="{{ $id ?? 'model-' . ($key = \Illuminate\Support\Str::random(20)) }}" dusk="{{ $id ?? $key }}" class="{{ $width ?? 'w-full' }} p-4">
        <table class="w-full text-sm bg-white text-gray-600">
            <thead class="uppercase">
                <tr class="border-b border-t border-gray-300 bg-blue-100 text-gray-600">
                    @foreach($columns as $tableHead)
                        <th class="pt-4 pb-5 px-6">{{ $tableHead }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach((new $model())->take($limit ?? Cookie::get('belich_perPage'))->get() as $row)
                    <tr class="hover:bg-gray-100">
                        @foreach($row->toArray() as $key => $value)
                            @if(in_array($key, $columns))
                                <td class="py-4 px-6 border-b border-solid border-gray-200">{{ $value }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div id="tool-model-error" dusk="tool-model-error" class="{{ $width ?? 'w-full' }} p-4">
        <div class="bg-red-500 text-white p-4 h-full">
            {!! Helper::icon('hand-paper', trans('belich::messages.fields.empty', ['value' => '$columns & $models'])) !!}
        </div>
    </div>
@endif
