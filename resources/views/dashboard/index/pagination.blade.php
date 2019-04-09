{{-- Pagination --}}
@if($pagination = $request->results->links())
    <tfoot class="bg-blue-100">
        <tr>
            <td colspan="{{ $request->total }}" class="text-center">{{ $pagination }}</td>
        </tr>
    </tfoot>
@endif
