<?php
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

class GoogleSheets
{
    private $worksheet;

    /**
     * Constructor
     *
     * @param string $accessToken       Access Token obtenido con Google API Client
     * @param string $spreadsheetName   Nombre del fichero Google Sheet
     * @param string $worksheetName     Nombre de la hoja del "Timeline"
     */
    public function __construct($accessToken, $spreadsheetName = 'timeline', $worksheetName = 'od1')
    {
        $serviceRequest = new DefaultServiceRequest($accessToken);
        ServiceRequestFactory::setInstance($serviceRequest);

        $spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
        $spreadsheetFeed = $spreadsheetService->getSpreadsheets();
        $spreadsheet = $spreadsheetFeed->getByTitle($spreadsheetName);
        $worksheetFeed = $spreadsheet->getWorksheets();
        $this->worksheet = $worksheetFeed->getByTitle($worksheetName);
    }

    /**
     * Devuelve las filas del Timeline.
     *
     * La primera fila se usa como nombres de columnas.
     * Se convierten a minusculas y se quitan espacios
     *
     * @return array
     */
    public function getRows()
    {
        $values = array();

        $listFeed = $this->worksheet->getListFeed();
        foreach ($listFeed->getEntries() as $entry) {
            $values[] = $entry->getValues();
        }

        return $values;
    }

    /**
     * Devuelve una fila del Timeline según el valor de la columna "id"
     *
     * @param string $id    Valor de la columna id a buscar
     * @return array() | null
     */
    public function getRow($id)
    {
        $queryString = 'id=' . $id;
        $listFeed = $this->worksheet->getListFeed($queryString);
        foreach ($listFeed->getEntries() as $entry) {
            return $entry->getValues();
        }

        return null;
    }

    /**
     * Inserta una nueva fila en la hoja Timeline.
     *
     * Los keys del array deben ser los mismos que se devuelven en $this->getRows()
     * Si no hay valor para $row['id'] se genera uno nuevo dependiente de la hora actual.
     *
     * @param array $row
     * @return string   Valor generado o enviado para la columna id.
     */
    public function insert($row)
    {
        $listFeed = $this->worksheet->getListFeed();

        if (empty($row['id'])) {
            $row['id'] = str_replace('.', '', microtime(true));
        }
        $listFeed->insert($row);

        return $id;
    }

    /**
     * Modifica los valores de una fila, segun el valor de la columna id
     *
     * @param string $id    Valor de la columna id a buscar
     * @param array $row
     */
    public function update($id, $row)
    {
        $queryString = 'id=' . $id;
        $listFeed = $this->worksheet->getListFeed($queryString);
        $entries = $listFeed->getEntries();

        if (count($entries) > 0) {
            $listEntry = $entries[0];
            foreach ($listEntry as $key => $value) {
                if (isset($row[$key])) {
                    $listEntry[$key] = $row[$key];
                }
            }
            $listEntry->update($row);
        }
    }

    /**
     * Elimina una fila, identifada según el valor de su columna id
     *
     * @param string $id    Valor de la columna id a buscar
     */
    public function delete($id)
    {
        $queryString = 'id=' . $id;
        $listFeed = $this->worksheet->getListFeed($queryString);
        $entries = $listFeed->getEntries();

        if (count($entries) > 0) {
            $listEntry = $entries[0];
            $listEntry->delete();
        }
    }
}