{{-- Pagination --}}
@if($pagination = $request->results->links())
    <tfoot class="bg-blue-100 border-b border-gray-400">
        <tr>
            <td colspan="{{ $request->total }}" class="text-center">{{ $pagination }}</td>
        </tr>
    </tfoot>
@endif
