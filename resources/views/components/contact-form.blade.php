@if (session('contact_success'))
    <div class="form-success">
        ✓ Demande envoyée ! On vous recontacte sous 24h.
    </div>
@else
    <form method="POST" action="{{ route('contact.store') }}" enctype="multipart/form-data" class="devis-form" id="contact-form">
        @csrf
        <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;">

        <div class="form-row">
            <div class="form-group @error('prenom') has-error @enderror">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Jean" value="{{ old('prenom') }}">
                @error('prenom') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group @error('nom') has-error @enderror">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Dupont" value="{{ old('nom') }}">
                @error('nom') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group @error('telephone') has-error @enderror">
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" placeholder="06 00 00 00 00" value="{{ old('telephone') }}">
                @error('telephone') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group @error('email') has-error @enderror">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="jean@exemple.fr" value="{{ old('email') }}">
                @error('email') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group @error('commune') has-error @enderror">
                <label for="commune">Commune</label>
                <input type="text" id="commune" name="commune" placeholder="Valence, Aubenas…" value="{{ old('commune') }}">
                @error('commune') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group @error('prestation') has-error @enderror">
                <label for="prestation">Prestation</label>
                <select id="prestation" name="prestation">
                    <option value="">Choisir…</option>
                    @foreach (\App\Models\ContactMessage::PRESTATIONS as $value => $label)
                        <option value="{{ $value }}" @selected(old('prestation') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('prestation') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group @error('message') has-error @enderror">
            <label for="message">Votre projet</label>
            <textarea id="message" name="message" placeholder="Surface approximative, nature du terrain, idées, délais souhaités…">{{ old('message') }}</textarea>
            @error('message') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Message vocal (optionnel)</label>
            <div class="audio-recorder" data-audio-recorder>
                <button type="button" class="audio-recorder-btn" data-record-btn aria-label="Démarrer l'enregistrement">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 14a3 3 0 003-3V5a3 3 0 10-6 0v6a3 3 0 003 3z"/><path d="M19 11a1 1 0 10-2 0 5 5 0 01-10 0 1 1 0 10-2 0 7 7 0 006 6.92V20H9a1 1 0 100 2h6a1 1 0 100-2h-2v-2.08A7 7 0 0019 11z"/></svg>
                </button>
                <span class="audio-recorder-status" data-status>Décrivez votre projet à l'oral (2 min max)</span>
                <audio controls style="display:none;" data-preview></audio>
                <button type="button" class="audio-recorder-reset" data-reset style="display:none;">Effacer</button>
            </div>
            <input type="file" name="audio" accept="audio/*" hidden data-audio-input>
            <input type="hidden" name="audio_duration_seconds" data-audio-duration>
        </div>

        <button type="submit" class="form-submit">Envoyer ma demande →</button>
        <p class="form-note">Réponse garantie sous 24h · Aucun démarchage</p>
    </form>
@endif
