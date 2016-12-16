<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;

class TodoController extends Controller
{

    protected $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function index()
    {

        $todos = [
            [
                'id'          => 1,
                'title'       => 'Write copy',
                'description' => 'We need this asap please!',
                'priority'    => 1,
                'assignee'    => 'John Doe',
                'date'        => '12/15/2016'
            ],
            [
                'id'          => 2,
                'title'       => 'Design wireframe',
                'description' => 'What we need is just a rough idea of the dimensions',
                'priority'    => 3,
                'assignee'    => 'Marcus Brown',
                'date'        => '12/19/2016'
            ],
            [
                'id'          => 3,
                'title'       => 'Create API',
                'description' => 'Requirements can be found in the usual folder.',
                'priority'    => 5,
                'assignee'    => 'Isabelle Red',
                'date'        => '12/23/2016'
            ]
        ];

        $people = [
            [
                'id'    => 1,
                'name'  => 'Joh Doe',
                'email' => 'joh@doe.com'
            ],
            [
                'id'    => 2,
                'name'  => 'Marcus Brown',
                'email' => 'marcus@brown.com'
            ],
            [
                'id'    => 3,
                'name'  => 'Isabelle Red',
                'email' => 'isabelle@red.com'
            ]
        ];

        return view('welcome')->withTodos($todos)->withPeople($people);
    }


    public function store(Request $request)
    {
        $inputs = $request->all();
        $assigneesArr = [];
        foreach ($inputs['assignees'] as $assignee) {
            if ($assignee == 1) {
                $assigneesArr[] = 'John Doe';
            } else if ($assignee == 2) {
                $assigneesArr[] = 'Marcus Brown';
            } else if ($assignee == 3) {
                $assigneesArr[] = 'Isabelle Red';
            }
        }
        $inputs['assignee'] = implode(', ', $assigneesArr);
        $inputs['date'] = (new Carbon($inputs['date']))->format('m/d/Y');

        return $this->createTodo($inputs);
    }





    public function storeExcel(Request $request)
    {

        $todos = [];
        if ($request->hasFile('excel')) {
            if ($request->file('excel')->isValid()) {

                $fileName = 'uploaded.' . $request->excel->getClientOriginalExtension();

                $request->excel->storeAs('temp', $fileName);

                $sheet = $this->excel->load('storage/app/temp/'.$fileName, function($reader) {

                })->get();

                $lines = $sheet->toArray();

                foreach($lines as $line){
                    $line['date'] = $line['date']->format('m/d/Y');
                    $todos[] = $this->createTodo($line);
                }

            }
        }

        return $todos;
    }





    public function storeCsv(Request $request)
    {
        $todos = [];

        $lines = explode("\n", $request->get('content'));

        $keys = [
            'title',
            'description',
            'priority',
            'assignee',
            'date'
        ];

        foreach ($lines as $line) {
            $values = explode($request->get('delimiter', ';'), $line);
            $diffArr = count($keys) - count($values);

            for ($i = 0; $i < $diffArr; $i++) {
                $values[] = '';
            }

            if (count($values) == count($keys)) {
                $todos[] = $this->createTodo(array_combine($keys, $values));
            }
        }

        return $todos;

    }


    private function createTodo($inputs)
    {
        return [
            'id'          => random_int(4, 10000),
            'title'       => ($inputs['title']) ? $inputs['title'] : 'No Title',
            'description' => ($inputs['description']) ? $inputs['description'] : 'No Description',
            'priority'    => ($inputs['priority']) ? intval($inputs['priority']) : 5,
            'assignee'    => ($inputs['assignee']) ? $inputs['assignee'] : 'John Doe',
            'date'        => ($inputs['date']) ? $inputs['date'] : Carbon::now()->format('m/d/Y')
        ];
    }
}
