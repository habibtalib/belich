{{-- Pagination --}}
@if($pagination = $request->results->links())
    <tfoot class="bg-blue-lightest">
        <tr>
            <td colspan="{{ $request->total }}" class="text-center">{{ $pagination }}</td>
        </tr>
    </tfoot>
@endif