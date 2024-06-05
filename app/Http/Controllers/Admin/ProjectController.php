<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        
        return view('admin.projects.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // dd($request->all());

        $validated = $request->validate(
            [
                'name' => 'required|min:5|max:150|unique:projects,name',
                'summary' => 'nullable|min:10',
                'cover_image' => 'nullable|image|max:256'
            ],

            [   'name.required' => 'Il campo titolo è obbligatorio',
                'name.max' => 'Il campo titolo non può avere più di 50 caratteri',
                'name.min' => 'Il campo titolo deve avere almeno 5 caratteri',
                'summary.min' => 'Il campo Descrizione deve avere almeno 10 caratteri',
            ]         
        );

        $formData = $request->all();
      
        //Salviamo immagine nel db solo se esiste cover_image
        if($request->hasFile('cover_image')) {       
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);         
            $formData['cover_image'] = $img_path;
        }

        $newProject = new Project();
        $newProject->fill($formData);
        $newProject->slug = Str::slug($newProject->name, '-');          
        $newProject->save();
     
        return redirect()->route('admin.projects.show', ['project' => $newProject->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
       return view('admin.projects.show',compact('project'));
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'min:5',
                    'max:150',
                    Rule::unique('projects')->ignore($project)
                ],
                'summary' => 'nullable|min:10',
                'cover_image' => 'nullable|image|max:256'
            ],
            [   'name.required' => 'Il campo titolo è obbligatorio',
                'name.max' => 'Il campo titolo non può avere più di 50 caratteri',
                'name.min' => 'Il campo titolo deve avere almeno 5 caratteri',
                'summary.min' => 'Il campo Descrizione deve avere almeno 10 caratteri',
            ]
        );
    
        $formData = $request->all();
        if($request->hasFile('cover_image')) {
            // Se avevo già un'immagine caricata la cancello
            if($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            // Upload del file nella cartella pubblica
            $img_path = Storage::disk('public')->put('post_images', $formData['cover_image']);
            // Salvare nella colonna cover_image del db il path all'immagine caricata
            $formData['cover_image'] = $img_path;
        }
        $project->slug = Str::slug($formData['name'], '-');
        $project->update($formData);

        return redirect()->route('admin.projects.show', ['project' => $project->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project-> delete();  
        return redirect()->route('admin.projects.index');
    }
}
