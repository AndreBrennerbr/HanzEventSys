<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Exception;
use App\Models\User;

class EventController extends Controller
{
    public function index(){

        $search = request('search');

        if($search){
            $events = Event::Where([
                ['title','like','%'.$search.'%']
            ])->get();
        }else{
            $events = Event::all();
        }

        return view('welcome',
        ['events'=>$events,'search'=>$search]   );
    }


    public function create(){
        return view('events.create');
    }


    public function store(Request $request){
        try{
                
            $event = new Event();

            $event->title = trim($request->title);
            $event->date = $request->date;
            $event->city = trim($request->city);
            $event->private = $request->private;
            $event->description = trim($request->description); 
            $event->items = $request->items;
    
            if($request->hasFile('image') && $request->file('image')->isValid()){
    
                $requestImage = $request->image;
                $extension = $requestImage->extension();
    
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
    
                $request->image->move('img/events',$imageName);
    
                $event->image = $imageName;
    
            }else{
    
                $event->image = 'defaultEvento.png';
    
            }

            $user = auth()->user();
            $event->user_id = $user->id;
            
            $event->save();
            
            return redirect('/')->with('msg','Evento criado com sucesso!');
        
        }catch(Exception $err){
            
            return redirect('/')->with('error','Error ao cadastrar evento, entre em contato com o administrador');
        }
        

    }

    public function show($id){

        $event = Event::findOrFail($id);

        $user = auth()->user();
        $hasUserJoined = false;

        if($user){
            $userEvents = $user->eventAsParticipant->toArray();

            foreach($userEvents as $userEvent){
                if($userEvent['id'] == $id)$hasUserJoined = true;
            }
        }

        $eventOwner = User::Where('id',$event->user_id)->first()->toArray();

        return view('events.show',['event'=>$event,'eventOwner'=>$eventOwner,'hasUserJoined'=>$hasUserJoined]);
    }


    public function dashboard(){
        $user = auth()->user();

        $events = $user->events;

        $eventAsParticipant = $user->eventAsParticipant;  

        return view('events.dashboard',['events'=>$events,'eventAsParticipant'=>$eventAsParticipant]);

    }


    public function destroy($id){
       try{
        Event::findOrFail($id)->delete();
        return redirect('/')->with('msg','Evento deletado com sucesso!');
       }catch(Exception $err){
        return redirect('/')->with('error','Error ao deletar evento, entre em contato com o administrador');
       }
     
    }

    public function edit($id){

        $user = auth()->user();
        
        $event = Event::findOrFail($id);

        if($user->id != $event->user_id)return redirect('/dashboard');

        return view('events.edit',['event' =>$event]);
    }


    public function update(Request $request){
        try{
            
            $data =$request->all();

            if($request->hasFile('image') && $request->file('image')->isValid()){
    
                $requestImage = $request->image;
                $extension = $requestImage->extension();
    
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
    
                $request->image->move('img/events',$imageName);
    
                $data['image'] = $imageName;
    
            }
           
            Event::findOrFail($request->id)->update($data);
            
            return redirect('/dashboard')->with('msg','Evento atualizado com sucesso!');
        
        }catch(Exception $err){

            return redirect('/dashboard')->with('error','Error ao atualizar evento, entre em contato com o administrador');
        }
       

    }

    public function joinEvent($id){
        
        //pega id do usuario autenticado
       try{
            $user = auth()->user();

            $user->eventAsParticipant()->attach($id);

            $event = Event::findOrFail($id);

            return redirect('/dashboard')->with('msg','Presença confirmada '.$event->title);

       }catch(Exception $err){
            return redirect('/dashboard')->with('error','Error se juntar ao evento, entre em contato com o administrador');
       } 



    } 
    
    
    public function leaveEvent($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);
        $user->eventAsParticipant()->detach($id);
        return redirect('/dashboard')->with('msg','Você saiu com suceso do evento: '.$event->title);
    }








}
