{{-- Pagination --}}
@if($pagination = $request->results->links())
    <tfoot class="bg-blue-100 shadow-md">
        <tr>
            <td colspan="{{ $request->total }}" class="text-center">
                <div id="{{ config('belich.pagination') === 'link' ? 'link-pagination' : 'simple-pagination' }}">
                    {{ $pagination }}
                </div>
            </td>
        </tr>
    </tfoot>
@endif
