<!-- Messages Content -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Expéditeur</th>
                                <th>Sujet</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages ?? [] as $message)
                            <tr>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->subject }}</td>
                                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $message->status == 'new' ? 'danger' : 'success' }}">
                                        {{ $message->status == 'new' ? 'Nouveau' : 'Lu' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.contacts.show', $message->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>