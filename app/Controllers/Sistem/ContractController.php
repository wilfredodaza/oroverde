<?php

namespace App\Controllers\Sistem;

use CodeIgniter\API\ResponseTrait;
use Mpdf\Mpdf;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Contract;
use App\Models\Movement;
use App\Models\Company;

class ContractController extends BaseController
{
    protected $c_model;
    protected $m_model;
    protected $co_model;
    use ResponseTrait;

    public function __construct(){
        $this->c_model  = new Contract();

        $this->m_model  = new Movement();
        $this->co_model  = new Company();
    }

    public function index()
    {

        $contract = $this->c_model->first();

        return view('contracts/index', [
            'contract' => $contract
        ]);
    }

    public function save(){
        try{
            $data = $this->request->getJson();

            $contrato = [
                'id'            => $data->contrato ?? "",
                'title'         => $data->title,
                'version'       => $data->version,
                'description'   => $data->description
            ];

            $contrato = array_filter($contrato, function($value) {
                return $value !== "";
            });

            
            $this->c_model->save($contrato);
            
            if(!isset($contrato['id'])){
                $id = $this->c_model->insertID();
                $contrato['contrato'] = $id;
            }



            return $this->respond(['data' => $contrato]);
        }catch(\Exception $e){
			return $this->respond(['title' => 'Error en el servidor', 'error' => $e->getMessage()], 500);
		}
    }

    public function pdf($movement_id){
        $movement   = $this->m_model->find($movement_id);
        $company    = $this->co_model
            ->select([
                'companies.*',
                'td.name as type_document',
                'td.abbreviation as type_abbreviation',
            ])
            ->join('type_documents td', 'td.id = companies.type_document_id', 'left')
            ->first();
        $contract   = $this->c_model->first();

        $hasBeneficiarios = count($movement->beneficiarios) > 0;
        $beneficiariosArray = $movement->beneficiarios ?? [];
        
        // return $this->respond($movement);

        $beneficiariosHtml = '';

        if (count($beneficiariosArray) > 0) {
            $beneficiariosHtml .= "<ul>";
            foreach ($beneficiariosArray as $b) {
                $beneficiariosHtml .= "<li>{$b->name}, $b->type_document_abr $b->number_document, de $b->issued.</li>";
            }
            $beneficiariosHtml .= "</ul>";
        } else {
            $beneficiariosHtml = null; // para que falle el IF
        }

        $firmas = view('pdf/firmas');

        $value = (float) $movement->value;
        $percentage = (float) $movement->percentage_discount;

        $discount = ($percentage / 100) * $value;
        $amount_discount = $value - $discount;


        $dictionary = [
            '{{TITLE}}'     => $contract->title,
            '{{VERSION}}'   => $contract->version,

            '{{FIRMAS}}'                => $firmas,

            '{{Numero_Contrato}}'   => $movement->resolution,

            '{{SEPARADOR}}'         => '<div style="border-bottom: 2px solid black"></div>',         

            // Company
            '{{COMPANY.NAME}}'                          => $company->name,
            '{{COMPANY.NIT}}'                           => number_format($company->number_nit, 0, ',', '.')."-{$company->dv}",
            '{{COMPANY.DV}}'                            => $company->dv,
            '{{COMPANY.UBICATION}}'                     => $company->ubication,
            '{{COMPANY.ORIGIN}}'                        => $company->origin,
            '{{COMPANY.REPRESENTATIVE}}'                => $company->propierty,
            '{{COMPANY.REPRESENTATIVE_TYPE_DOCUMENT}}'  => "$company->type_document ($company->type_abbreviation)",
            '{{COMPANY.REPRESENTATIVE_TYPE_DOCUMENT_ABBR}}'  => "$company->type_abbreviation",
            '{{COMPANY.REPRESENTATIVE_NUMBER}}'         => number_format($company->number_document, 0, ',', '.'),
            '{{COMPANY.REPRESENTATIVE_ISSUED}}'         => "$company->issued",

            // Cliente
            '{{CUSTOMER.NAME}}'                 => $movement->customer->name,
            '{{CUSTOMER.TYPE_DOCUMENT}}'        => "{$movement->customer->type_document_name} ({$movement->customer->type_document_abr})",
            '{{CUSTOMER.TYPE_DOCUMENT_ABBR}}'   => "{$movement->customer->type_document_abr}",
            '{{CUSTOMER.NUMBER}}'               => number_format($movement->customer->number_document, 0, ',', '.'),
            '{{CUSTOMER.ISSUED}}'               => $movement->customer->issued,
            '{{PROGRAM_NAME}}'                  => $movement->project->name,

            // Datos venta
            '{{QUANTITY_LETTER}}'               => quantityLetter($movement->detail->quantity),
            '{{QUANTITY}}'                      => number_format($movement->detail->quantity, 0, ',', '.'),
            '{{AMOUNT_LETTER}}'                 => numberLetter($movement->value),
            '{{AMOUNT}}'                        => number_format($movement->value, 0, ',', '.'),
            '{{PERCENTAGE_LETTER}}'             => porcentajeALetras($movement->project->percentage_profit),
            '{{PERCENTAGE}}'                    => number_format($movement->project->percentage_profit, 2, '.', '.'),
            '{{PERCENTAGE_DISCOUNT}}'           => number_format($movement->percentage_discount, 2, '.', '.'),
            '{{AMOUNT_LETTER_DISCOUNT}}'        => numberLetter($amount_discount),
            '{{AMOUNT_DISCOUNT}}'               => number_format($amount_discount, 0, ',', '.'),
            '{{REMAINING_PERCENTAGE_LETTER}}'   => porcentajeALetras(100 - (float)$movement->project->percentage_profit),
            '{{REMAINING_PERCENTAGE}}'          => number_format(100 - (float)$movement->project->percentage_profit, 2, '.', '.'),
            '{{YEARS_LETTER}}'                  => numberYearLetter($movement->project->project_years),
            '{{YEARS}}'                         => $movement->project->project_years,
            '{{IF(BENEFICIARIOS):}}'  => $hasBeneficiarios ? '{{SHOW}}' : '{{HIDE}}',
            '{{ELSE:}}'               => '{{ELSE}}',
            '{{ENDIF}}'               => '{{ENDIF}}',
            '{{BENEFICIARIOS}}'       => $beneficiariosHtml,
            '{{DAY_CREATED}}'             => date('d', strtotime($movement->created_at)),
            '{{MONTH_CREATED}}'             => date('m', strtotime($movement->created_at)),
            '{{YEAR_CREATED}}'             => date('Y', strtotime($movement->created_at)),
        ];

        
        $template = str_replace(array_keys($dictionary), array_values($dictionary), $contract->description);
        // $template = str_replace(array_keys($dictionary), array_values($dictionary), $template);

        $template = renderTemplate($template, $dictionary);

        $template = '<div class="content">'.$template.'</div>';

        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf = new Mpdf([
			'mode'          => 'utf-8',
			'format'        => 'Letter',
			"margin_left"   => 5,
			"margin_right"  => 5,
			"margin_top"    => 10,
			"margin_bottom" => 17,
			"margin_header" => 5
		]);

        // $mpdf->SetHTMLHeader('
		// 	<table width="100%">
		// 		<tr>
		// 			<td width="100%" align="center" style="font-size:10px">Página <b>{PAGENO}</b> de <b>{nbpg}</b></td>
		// 		</tr>
		// 	</table>
        // 	<hr>
		// ');

        // print(FCPATH); die;
        $css = file_get_contents(FCPATH . 'pdf/contract.css');
        $inter = file_get_contents(FCPATH . 'pdf/inter.css');
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($inter, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($template);
        $mpdf->SetTitle("Contrato #$movement->resolution");
        $mpdf->Output("contrato_{$movement->resolution}.pdf", 'I');
    }
}
