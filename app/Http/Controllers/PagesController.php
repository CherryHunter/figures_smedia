<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Figure;
use App\Notification;
use App\ActualNotification;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Comment;
use App\Rating;
use App\User;
use App\Friend;
use App\Mailbox;
use Image;
use Auth;
use Validator;
use App\Collection;
use App\Report;
use Illuminate\Support\MessageBag;


class PagesController extends Controller
{

    public function index(){
      $figures = Figure::orderBy('id','desc')->paginate(9);
      return view('pages.index')->with('figures', $figures);


    }

    public function search(Request $request){
      $name = $request->get('keyword');
      $figures = Figure::where('title', 'LIKE', '%'.$name.'%')->orderBy('id','desc')->get();
      //$figures = Figure::where('title', 'LIKE', '%'.$name.'%')->orderBy('id','desc')->paginate(9);
      return view('pages.index')->with('figures', $figures);
    }

//$figures = Figure::orderBy($what,$how)->paginate(9);

    public function sortby(Request $request){
      $what = $request->get('what');
      $how = $request->get('how');
      if ($what == 'price'){
        $figuresTemp = Figure::all();
        $figures = [];
        foreach($figuresTemp as $figure){
          array_push($figures, $figure);
        }
        usort($figures, function ($figure1, $figure2) use ($how) {
          if($how == 'desc'){
          return $figure2->sales[0]->price <=> $figure1->sales[0]->price;
          }
          else{
          return $figure1->sales[0]->price <=> $figure2->sales[0]->price;
          }
        });
      $figures = collect($figures);
      $figures->simplePaginate(9);
      }
      else{
      $figures = Figure::orderBy($what,$how)->paginate(9);
      }
      return view('pages.index')->with('figures', $figures)->with('how', $how)->with('what', $what);

    }

    public function top10(){
      $figures = Figure::orderBy('popularity','desc')->take(10)->get();
      return view('pages.top10')->with('figures', $figures);
    }

    public function notifications(){
      $actual_notifications = ActualNotification::where('user_id', auth()->user()->id)->get();
      $f_requests = Friend::where('user2_id', auth()->user()->id)->where('accepted','0')->get();
      return view('pages.notifications')->with('actual_notifications', $actual_notifications)->with('f_requests',$f_requests);
    }

    // Figure ----------------------------------------------

    public function figure($id){
      $figure = Figure::find($id);
      return view('pages.figure')->with('figure', $figure);
    }

    public function notification($id){

      $notifications = Notification::where('user_id', auth()->user()->id)->where('character_id', $id)->get();
      if (count($notifications) == 0)
        Notification::create(array(
          'user_id'=> auth()->user()->id,
          'character_id'=> $id,
        ));

      return back()->with('message','Powiadomienie dodane');
    }

    public function delete_notification($id){
      $d_notification = ActualNotification::find($id);
      $d_notification->delete();
      return back()->with('message', 'Powiadomienie usunięte');
    }

    public function add_comment(Request $request){
      Comment::create(array(
        'body' => $request->get('body'),
        'user_id' => auth()->user()->id,
        'figure_id' => $request->get('figure_id'),
      ));


      return redirect()->route('show_figure',['id'=>$request->get('figure_id')])->with('message', 'Komentarz dodany pomyślnie');
    }

    public function delete_comment($id){
      $comment = Comment::find($id);
      $comment->delete();
      return back()->with('message', 'Komentarz usunięty pomyślnie');
    }

    public function report_comment($id){
      $comment = Comment::find($id);
      $comment->increment("reported");
      return back()->with('message', 'Komentarz został zgłoszony');
    }

    public function add_like($id){

        if (count(Rating::where('user_id', auth()->user()->id)->where('figure_id', $id)->get()) == 0){
        $figure = Figure::find($id);
    	  $figure->increment("popularity");

        Rating::create(array(
        'user_id'=> auth()->user()->id,
        'figure_id'=> $id,
      ));
      }
      return back();
    }

    public function add_tocollection($id){

        if (count(Collection::where('user_id', auth()->user()->id)->where('figure_id', $id)->get()) == 0){

        Collection::create(array(
        'user_id'=> auth()->user()->id,
        'figure_id'=> $id,
      ));
      }
      return back()->with('message', 'Figurka została dodana do kolekcji');
    }

// Profile ----------------------------------------------

    public function profile($name){
      $user = User::where('name', $name)->first();
      if ( (count(Friend::where('user1_id', auth()->user()->id)->where('user2_id', $user->id)->where('accepted','0')->get()) == 1) ||
     (count(Friend::where('user1_id', $user->id)->where('user2_id', auth()->user()->id)->where('accepted','0')->get()) == 1) ){
      $requested = 1;
      }
      else if ( (count(Friend::where('user1_id', auth()->user()->id)->where('user2_id', $user->id)->where('accepted','1')->get()) == 1)||
      (count(Friend::where('user1_id', $user->id)->where('user2_id', auth()->user()->id)->where('accepted','1')->get()) == 1) )  {
      $requested = 2;
      }
      else{
      $requested = 0;
      }
      return view('pages.profile')->with('user', $user)->with('requested',$requested);
    }

    public function add_friend($id){
      Friend::create(array(
        'user1_id' => auth()->user()->id,
        'user2_id' => $id,
      ));

      return back()->with('message', 'Zaproszenie wysłane');
    }

    public function accept_friend($id){
      $friendship = Friend::find($id);
      $friendship->increment("accepted");

      return back();
    }

    public function delete_friend($id){
    $d_friendship = Friend::find($id);
    $d_friendship->delete()->with('message', 'Użytkownik został usunięty ze znajomych');

      return back();
    }

    public function report_user(Request $request){
      $user = User::find($request->get('id'));
      $user->increment("reported");
      Report::create(array(
        'body' => $request->get('body'),
        'user_id' => $request->get('id'),
      ));
      return back()->with('message', 'Użytkownik został pomyślnie zgłoszony');
    }

    public function send_message(Request $request){
      $receiver_id = User::where('name', $request->get('receiver'))->first();
      if( (!empty($receiver_id)) and (auth()->user()->id)!=($receiver_id['id'])){
      Mailbox::create(array(
        'body' => $request->get('body'),
        'sender_id' => auth()->user()->id,
        'receiver_id' => $receiver_id['id'],
      ));}

      return back()->with('message', 'Wiadomość została wysłana');
    }

    public function edit_description(Request $request){
      $description = User::find(auth()->user()->id);
      $description->description = $request->get('description');
      $description->save();

      return back()->with('message', 'Opis edytowany pomyślnie');
    }

    public function change_av(Request $request){

      if($request->hasFile('avatar')){
        $avatar = $request->file('avatar');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->resize(200,200)->save( public_path('images/avatars/' . $filename));
        $user = Auth::user();
        $user->avatar = $filename;
        $user->save();
      }
      return back()->with('message', 'Avatar został zmieniony');
    }

    public function delete_from_collection($id){
      $item = Collection::find($id);
      $item->delete();
      return back()->with('message', 'Figurka została usunięta z kolekcji');
    }

    // Admin  ----------------------------------------------

    public function admin(){
      $comments = Comment::orderBy('id','desc')->get();
      $reported_comments = Comment::where('reported', '>=', 1)->get();
      $reports = Report::all();
      return view('pages.adminpanel')->with('comments',$comments)->with('reported_comments',$reported_comments)->with('reports',$reports);
    }

    public function ban_user($id){
      $user = User::find($id);
      $user->increment("banned");
      return back()->with('message', 'Użytkownik został zbanowany');
    }

    public function delete_report($id){
      $report = Report::find($id);
      $report->delete();
      return back()->with('message', 'Zgłoszenie usunięte');
    }

    public function delete_report_com($id){
      $report = Comment::find($id);
      $report->reported = '0';
      $report->save();
      return back()->with('message', 'Komentarz usunięty');
    }

    // Mailbox  ----------------------------------------------

    public function mailbox(){
      $received = Mailbox::where('receiver_id',auth()->user()->id)->where('delete_received','0')->get();
      $sent = Mailbox::where('sender_id',auth()->user()->id)->where('delete_sent','0')->get();
      return view('pages.mailbox')->with('received',$received)->with('sent',$sent);
    }

    public function delete_sent($id){
      $sent = Mailbox::find($id);
      $sent->increment("delete_sent");
      //return back();
      return $this->delete_message();
    }

    public function delete_received($id){
      $sent = Mailbox::find($id);
      $sent->increment("delete_received");
      //return back();
      return $this->delete_message();
    }

    public function delete_message(){
      $message = Mailbox::where('delete_sent','1')->where('delete_received','1')->first();
      if (!empty($message)){
      $message->delete();}
      return back()->with('message', 'Wiadomość usunięta pomyślnie');

    }

    // Users ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public function users(){
      $users = User::all();
      return view('pages.users')->with('users', $users);
    }

    public function search_users(Request $request){
      $name = $request->get('keyword');
      $users = User::where('name', 'LIKE', '%'.$name.'%')->get();
      return view('pages.users')->with('users', $users);
    }

}
