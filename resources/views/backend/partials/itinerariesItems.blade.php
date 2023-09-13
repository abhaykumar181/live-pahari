@php for($itineraryItem = 0; $itineraryItem < $itenariesDays; $itineraryItem++): @endphp 
    @php
        $title = $description = '';
        if(isset($packageItineraries)):
            if(isset($packageItineraries[$itineraryItem])):
                $title = $packageItineraries[$itineraryItem]['title'];
                $description = $packageItineraries[$itineraryItem]['description'];
            endif;
        endif;

        $title = isset(old('itinaryTitle')[$itineraryItem]) ? old('itinaryTitle')[$itineraryItem] : $title;
        $description = isset(old('itineraryDescription')[$itineraryItem]) ? old('itineraryDescription')[$itineraryItem] : $description;
    @endphp
    <div class="itinerary-item">
        <h2 class="accordion-header" id="heading{{$currentItems}}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"  data-bs-target="#collapse{{$currentItems}}" aria-expanded="false" aria-controls="collapse{{$currentItems}}">
            Day {{$currentItems}}
            </button>
        </h2>
        <div id="collapse{{$currentItems}}" class="accordion-collapse collapse" aria-labelledby="heading{{$currentItems}}" data-bs-parent="#packageItinerariesItems">
            <div class="accordion-body">
                <div class="form-floating mb-3">
                    <input type="hidden" name="itineraryDay[]" value="{{$currentItems}}" >
                    <input type="text" class="form-control shadow-sm" id="itinaryTitle" name="itinaryTitle[]"  placeholder="Enter itinerary Title" value="{{ $title }}">
                    <label for="itinaryTitle">Itinerary Title</label>                
                </div>

                <div class="form-floating">
                    <textarea class="form-control shadow-sm" placeholder="Enter Itinerary description.."  name="itineraryDescription[]" id="itineraryDescription" style="height: 140px">{{$description}}</textarea>
                    <label for="itineraryDescription">Description</label>
                </div>
            </div>
        </div>
    </div>
    @php $currentItems++; @endphp
@php endfor; @endphp