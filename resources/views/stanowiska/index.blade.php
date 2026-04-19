@extends('layouts.app')

@section('title', __('app.stanowiska.page_title'))

@section('content')
    @php
        $saveUrl = \App\Support\AppUrl::route('stanowiska.kolejnosc');
    @endphp
    <style>
        .stanowiska-toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem 1rem; margin-bottom: 1rem; }
        .stanowiska-siatka-link {
            display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: #fff; color: #1e40af; border: 1px solid #1e40af; border-radius: 0.375rem;
            font-weight: 600; font-size: 0.9375rem; text-decoration: none;
        }
        .stanowiska-siatka-link:hover { background: #eff6ff; }
        .stanowiska-zapisz-btn { display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.9375rem; cursor: pointer; }
        .stanowiska-zapisz-btn:hover { background: #1d4ed8; }
        .stanowiska-zapisz-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .stanowiska-msg { font-size: 0.875rem; font-weight: 500; color: #047857; min-height: 1.25rem; }
        .stanowiska-msg--err { color: #b91c1c; }
        #stanowiska-lista {
            display: flex; flex-direction: column; align-items: flex-start; gap: 0;
            width: 100%; max-width: min(100%, 120ch); box-sizing: border-box;
        }
        .stanowiska-rzad {
            display: flex; flex-direction: row; align-items: stretch; gap: 0.35rem;
            margin-bottom: 0;
            width: fit-content;
            max-width: 100%;
            box-sizing: border-box;
        }
        /* Pełna szerokość listy — brak „wąskiego paska” obok szerokich wierszy (to wyglądało jak wcięcie) */
        .stanowiska-rzad--insert {
            align-self: stretch;
            width: 100%;
            max-width: 100%;
            margin-bottom: 0;
            line-height: 0;
            box-sizing: border-box;
            align-items: center;
        }
        .rzad-handle--ghost {
            visibility: hidden;
            pointer-events: none;
            cursor: default;
        }
        /* Bez tego niewidoczny „⋮⋮” ma min-height 2.75rem jak prawdziwy uchwyt = ogromna szczelina między każdymi liniami */
        .stanowiska-rzad--insert .rzad-handle.rzad-handle--ghost {
            min-height: 0;
            height: 2px;
            padding: 0;
            line-height: 0;
            font-size: 0;
            align-self: center;
            border-color: transparent;
        }
        .stanowiska-rzad--insert .stanowiska-rzad-tiles.stanowiska-rzad-tiles--empty {
            flex: 1 1 auto;
            min-width: 0;
            min-height: 12px;
            box-sizing: border-box;
        }
        .stanowiska-rzad--after-break {
            margin-top: 0.35rem; padding-top: 0.35rem; border-top: 2px solid #e5e7eb;
        }
        .rzad-handle {
            flex-shrink: 0; width: 2.25rem; min-height: 2.75rem; padding: 0; margin: 0;
            box-sizing: border-box;
            display: inline-flex; align-items: center; justify-content: center;
            background: linear-gradient(180deg, #f3f4f6 0%, #e5e7eb 100%);
            border: 1px solid #9ca3af; border-radius: 0.375rem;
            color: #374151; cursor: grab; font-size: 0.8125rem; font-weight: 700; line-height: 1;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }
        .rzad-handle:hover {
            background: linear-gradient(180deg, #e5e7eb 0%, #d1d5db 100%);
            border-color: #6b7280;
            color: #111827;
        }
        .rzad-handle:focus-visible {
            outline: 2px solid #2563eb;
            outline-offset: 2px;
        }
        .rzad-handle:active { cursor: grabbing; }
        .stanowiska-lista--readonly .rzad-handle { display: none; }
        .stanowiska-rzad-tiles {
            display: flex; flex-direction: row; flex-wrap: wrap; align-items: stretch;
            gap: 0.35rem; flex: 1; min-width: 0;
        }
        .stanowiska-lista--readonly .stanowisko-kafelek { cursor: default; }
        .stanowiska-lista--readonly .stanowisko-kafelek:active { cursor: default; }
        .stanowisko-kafelek {
            display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;
            padding: 0.75rem 1rem; background: #fff; border: 1px solid #e5e7eb; border-radius: 0.5rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05); cursor: grab; user-select: none;
            box-sizing: border-box;
            flex: 0 1 auto;
            width: var(--stanowiska-kafelek-w, auto);
            min-width: 0;
            max-width: 100%;
        }
        .stanowiska-lista--readonly .stanowisko-przeciagnij { display: none; }
        .stanowisko-kafelek:active { cursor: grabbing; }
        .stanowiska-rzad.is-dragging { opacity: 0.55; }
        .stanowisko-kafelek.is-dragging { opacity: 0.55; }
        .stanowisko-nazwa { font-weight: 600; color: #111; flex: 1; min-width: 0; word-break: break-word; overflow-wrap: anywhere; }
        .stanowisko-przeciagnij { color: #9ca3af; flex-shrink: 0; }
    </style>

    <div style="margin-bottom: 1rem;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin: 0;">{{ __('app.stanowiska.heading') }}</h1>
        <p style="margin-top: 0.5rem; color: #4b5563; max-width: 42rem;">{{ __('app.stanowiska.intro') }}</p>
    </div>

    @if($rowsNowe === [] && $rowsZapamietane === [])
        <p style="color: #6b7280;">{{ __('app.stanowiska.empty') }}</p>
    @else
        <div class="stanowiska-toolbar">
            <a href="{{ \App\Support\AppUrl::route('stanowiska.siatka-wynagrodzen') }}" class="stanowiska-siatka-link">{{ __('app.stanowiska.siatka_link') }}</a>
            @if($canSaveOrder)
            <button type="button" id="stanowiska-zapisz" class="stanowiska-zapisz-btn">{{ __('app.stanowiska.remember_order') }}</button>
            <span id="stanowiska-msg" class="stanowiska-msg" role="status" aria-live="polite"></span>
            @endif
        </div>
        @if($canSaveOrder)
        <p style="font-size: 0.8125rem; color: #6b7280; margin-bottom: 0.75rem; max-width: 42rem;">{{ __('app.stanowiska.hint_drop_new_row') }}</p>
        @endif

        @if($maObaBloki)
            <p style="font-size: 0.8125rem; color: #6b7280; margin-bottom: 0.75rem; max-width: 42rem;">{{ __('app.stanowiska.hint_new_block') }}</p>
        @endif

        <div id="stanowiska-lista" class="@if(!$canSaveOrder) stanowiska-lista--readonly @endif" data-row-drag-label="{{ __('app.stanowiska.row_drag_label') }}">
            @foreach($rowsNowe as $row)
                <div class="stanowiska-rzad">
                    @if($canSaveOrder)
                        <button type="button" class="rzad-handle" aria-label="{{ __('app.stanowiska.row_drag_label') }}">⋮⋮</button>
                    @endif
                    <div class="stanowiska-rzad-tiles">
                        @foreach($row as $wiersz)
                            <div class="stanowisko-kafelek" data-stanowisko="{{ $wiersz->stanowisko }}">
                                <span class="stanowisko-nazwa">{{ $wiersz->stanowisko }}</span>
                                @if($canSaveOrder)
                                    <span class="stanowisko-przeciagnij" aria-hidden="true">⋮⋮</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            @foreach($rowsZapamietane as $row)
                <div class="stanowiska-rzad @if($loop->first && $maObaBloki) stanowiska-rzad--after-break @endif">
                    @if($canSaveOrder)
                        <button type="button" class="rzad-handle" aria-label="{{ __('app.stanowiska.row_drag_label') }}">⋮⋮</button>
                    @endif
                    <div class="stanowiska-rzad-tiles">
                        @foreach($row as $wiersz)
                            <div class="stanowisko-kafelek" data-stanowisko="{{ $wiersz->stanowisko }}">
                                <span class="stanowisko-nazwa">{{ $wiersz->stanowisko }}</span>
                                @if($canSaveOrder)
                                    <span class="stanowisko-przeciagnij" aria-hidden="true">⋮⋮</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <script>
        (function () {
            function syncStanowiskaKafelekWidth(lista) {
                if (!lista) {
                    return;
                }
                var nazwy = lista.querySelectorAll('.stanowisko-nazwa');
                if (!nazwy.length) {
                    return;
                }
                var maxN = 0;
                [].forEach.call(nazwy, function (n) {
                    var prev = n.style.whiteSpace;
                    n.style.whiteSpace = 'nowrap';
                    maxN = Math.max(maxN, n.scrollWidth);
                    n.style.whiteSpace = prev;
                });
                var k0 = lista.querySelector('.stanowisko-kafelek');
                if (!k0) {
                    return;
                }
                var cs = getComputedStyle(k0);
                var padX = parseFloat(cs.paddingLeft) + parseFloat(cs.paddingRight);
                var borderX = parseFloat(cs.borderLeftWidth) + parseFloat(cs.borderRightWidth);
                var gapRaw = cs.columnGap || cs.gap || '0';
                var gapPx = parseFloat(gapRaw);
                if (Number.isNaN(gapPx)) {
                    gapPx = 0;
                }
                var icon = k0.querySelector('.stanowisko-przeciagnij');
                var iconW = icon ? icon.getBoundingClientRect().width : 0;
                var wPx = Math.ceil(maxN + padX + borderX + gapPx + iconW);
                lista.style.setProperty('--stanowiska-kafelek-w', wPx + 'px');
            }

            window.syncStanowiskaKafelekWidthFromLista = function () {
                syncStanowiskaKafelekWidth(document.getElementById('stanowiska-lista'));
            };

            function run() {
                window.syncStanowiskaKafelekWidthFromLista();
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', run);
            } else {
                run();
            }
            window.addEventListener('resize', function () {
                run();
            });
        })();
        </script>

        @if($canSaveOrder)
        <script>
        (function() {
            var lista = document.getElementById('stanowiska-lista');
            var btn = document.getElementById('stanowiska-zapisz');
            var msg = document.getElementById('stanowiska-msg');
            var saveUrl = @json($saveUrl);
            var csrf = @json(csrf_token());
            if (!lista || !btn || !msg) return;

            var rowLabel = lista.getAttribute('data-row-drag-label') || '';
            var dndKind = null;
            var dndRowEl = null;
            var dndTileEl = null;

            function createInsertZone() {
                var wrap = document.createElement('div');
                wrap.className = 'stanowiska-rzad stanowiska-rzad--insert';
                wrap.setAttribute('aria-hidden', 'true');
                var ghost = document.createElement('button');
                ghost.type = 'button';
                ghost.className = 'rzad-handle rzad-handle--ghost';
                ghost.setAttribute('disabled', 'disabled');
                ghost.setAttribute('tabindex', '-1');
                ghost.setAttribute('aria-hidden', 'true');
                ghost.appendChild(document.createTextNode('⋮⋮'));
                var tiles = document.createElement('div');
                tiles.className = 'stanowiska-rzad-tiles stanowiska-rzad-tiles--empty';
                wrap.appendChild(ghost);
                wrap.appendChild(tiles);
                return wrap;
            }

            function ensureInsertZones() {
                [].forEach.call(lista.querySelectorAll('.stanowiska-rzad--insert'), function(rzad) {
                    if (rzad.querySelectorAll('.stanowisko-kafelek').length > 0) {
                        rzad.classList.remove('stanowiska-rzad--insert');
                        rzad.removeAttribute('aria-hidden');
                        var ghost = rzad.querySelector('.rzad-handle--ghost');
                        if (ghost && !rzad.querySelector('.rzad-handle:not(.rzad-handle--ghost)')) {
                            var h = document.createElement('button');
                            h.type = 'button';
                            h.className = 'rzad-handle';
                            h.setAttribute('aria-label', rowLabel);
                            h.appendChild(document.createTextNode('⋮⋮'));
                            ghost.replaceWith(h);
                        }
                    }
                });
                [].forEach.call(lista.querySelectorAll('.stanowiska-rzad--insert'), function(rzad) {
                    rzad.remove();
                });
                var rows = [].slice.call(lista.querySelectorAll(':scope > .stanowiska-rzad'));
                rows.forEach(function(row) {
                    lista.insertBefore(createInsertZone(), row);
                });
                if (rows.length) {
                    rows[rows.length - 1].after(createInsertZone());
                }
            }

            function pruneEmptyRows() {
                [].forEach.call(lista.querySelectorAll(':scope > .stanowiska-rzad:not(.stanowiska-rzad--insert)'), function(rzad) {
                    if (rzad.querySelectorAll('.stanowisko-kafelek').length === 0) {
                        rzad.remove();
                    }
                });
            }

            function setDraggableAttrs() {
                [].forEach.call(lista.querySelectorAll('.rzad-handle:not(.rzad-handle--ghost)'), function(h) {
                    h.setAttribute('draggable', 'true');
                });
                [].forEach.call(lista.querySelectorAll('.stanowisko-kafelek'), function(k) {
                    k.setAttribute('draggable', 'true');
                });
                [].forEach.call(lista.querySelectorAll('.rzad-handle--ghost'), function(h) {
                    h.removeAttribute('draggable');
                });
            }

            function clearDndVisual() {
                [].forEach.call(lista.querySelectorAll('.is-dragging'), function(el) {
                    el.classList.remove('is-dragging');
                });
            }

            function afterDomChange() {
                pruneEmptyRows();
                ensureInsertZones();
                if (window.syncStanowiskaKafelekWidthFromLista) {
                    window.syncStanowiskaKafelekWidthFromLista();
                }
                setDraggableAttrs();
            }

            function tileInsertBefore(tilesEl, clientX, excludeEl) {
                var tiles = [].slice.call(tilesEl.querySelectorAll(':scope > .stanowisko-kafelek'));
                for (var i = 0; i < tiles.length; i++) {
                    var t = tiles[i];
                    if (t === excludeEl) {
                        continue;
                    }
                    var r = t.getBoundingClientRect();
                    if (clientX < r.left + r.width / 2) {
                        return t;
                    }
                }
                return null;
            }

            lista.addEventListener('dragstart', function(e) {
                var handle = e.target.closest('.rzad-handle:not(.rzad-handle--ghost)');
                if (handle && lista.contains(handle)) {
                    dndKind = 'row';
                    dndRowEl = handle.closest('.stanowiska-rzad');
                    dndTileEl = null;
                    dndRowEl.classList.add('is-dragging');
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', 'nivo-row');
                    return;
                }
                var tile = e.target.closest('.stanowisko-kafelek');
                if (tile && lista.contains(tile)) {
                    dndKind = 'tile';
                    dndTileEl = tile;
                    dndRowEl = null;
                    dndTileEl.classList.add('is-dragging');
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', 'nivo-tile');
                    return;
                }
                e.preventDefault();
            });

            lista.addEventListener('dragend', function() {
                clearDndVisual();
                dndKind = null;
                dndRowEl = null;
                dndTileEl = null;
            });

            lista.addEventListener('dragenter', function(e) {
                if (dndKind === 'row' && dndRowEl && e.target.closest('.stanowiska-rzad')) {
                    e.preventDefault();
                }
                if (dndKind === 'tile' && dndTileEl) {
                    var t = e.target.closest('.stanowiska-rzad-tiles');
                    if (t && lista.contains(t)) {
                        e.preventDefault();
                    }
                }
            });

            lista.addEventListener('dragover', function(e) {
                if (dndKind === 'row' && dndRowEl) {
                    var ins = e.target.closest('.stanowiska-rzad--insert');
                    var row = e.target.closest('.stanowiska-rzad:not(.stanowiska-rzad--insert)');
                    if (ins || row) {
                        e.preventDefault();
                        e.dataTransfer.dropEffect = 'move';
                    }
                    return;
                }
                if (dndKind === 'tile' && dndTileEl) {
                    var tiles = e.target.closest('.stanowiska-rzad-tiles');
                    if (tiles && lista.contains(tiles)) {
                        e.preventDefault();
                        e.dataTransfer.dropEffect = 'move';
                    }
                }
            });

            lista.addEventListener('drop', function(e) {
                e.preventDefault();
                if (dndKind === 'row' && dndRowEl) {
                    var ins = e.target.closest('.stanowiska-rzad--insert');
                    if (ins) {
                        var next = ins.nextElementSibling;
                        while (next && next.classList.contains('stanowiska-rzad--insert')) {
                            next = next.nextElementSibling;
                        }
                        if (next === dndRowEl) {
                            return;
                        }
                        if (next) {
                            lista.insertBefore(dndRowEl, next);
                        } else {
                            lista.appendChild(dndRowEl);
                        }
                        afterDomChange();
                        return;
                    }
                    var row = e.target.closest('.stanowiska-rzad:not(.stanowiska-rzad--insert)');
                    if (row && row !== dndRowEl && lista.contains(row) && !dndRowEl.contains(row)) {
                        lista.insertBefore(dndRowEl, row);
                        afterDomChange();
                    }
                    return;
                }
                if (dndKind === 'tile' && dndTileEl) {
                    var insRow = e.target.closest('.stanowiska-rzad--insert');
                    if (insRow) {
                        var tIns = insRow.querySelector('.stanowiska-rzad-tiles');
                        if (tIns) {
                            var refI = tileInsertBefore(tIns, e.clientX, dndTileEl);
                            if (refI) {
                                tIns.insertBefore(dndTileEl, refI);
                            } else {
                                tIns.appendChild(dndTileEl);
                            }
                            afterDomChange();
                        }
                        return;
                    }
                    var rowT = e.target.closest('.stanowiska-rzad:not(.stanowiska-rzad--insert)');
                    if (!rowT || !lista.contains(rowT)) {
                        return;
                    }
                    var tilesT = rowT.querySelector('.stanowiska-rzad-tiles');
                    if (!tilesT) {
                        return;
                    }
                    var ref = tileInsertBefore(tilesT, e.clientX, dndTileEl);
                    if (ref) {
                        tilesT.insertBefore(dndTileEl, ref);
                    } else {
                        tilesT.appendChild(dndTileEl);
                    }
                    afterDomChange();
                }
            });

            afterDomChange();

            btn.addEventListener('click', function() {
                msg.textContent = '';
                msg.classList.remove('stanowiska-msg--err');
                var order = [];
                [].forEach.call(lista.querySelectorAll(':scope > .stanowiska-rzad:not(.stanowiska-rzad--insert)'), function(rzad) {
                    var names = [].map.call(rzad.querySelectorAll('.stanowisko-kafelek'), function(k) {
                        return k.getAttribute('data-stanowisko');
                    }).filter(Boolean);
                    if (names.length) {
                        order.push(names);
                    }
                });
                btn.disabled = true;
                fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ order: order }),
                }).then(function(r) {
                    if (!r.ok) return r.json().then(function() { throw new Error(); });
                    return r.json();
                }).then(function() {
                    window.location.reload();
                }).catch(function() {
                    msg.classList.add('stanowiska-msg--err');
                    msg.textContent = @json(__('app.stanowiska.flash_order_error'));
                }).finally(function() {
                    btn.disabled = false;
                });
            });
        })();
        </script>
        @endif
    @endif
@endsection
