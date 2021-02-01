import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Praticien } from "../models/praticien.model";
import { Specialite } from "../models/specialite.model";

@Injectable({providedIn: 'root'})
export class PraticienService {
  listePraticiens: Praticien[];
  constructor (private http: HttpClient){

  }

  searchAllPraticiens(){
    return this.http.get<Praticien[]>("http://localhost:8000/praticiens", {observe: 'response'});
  }

  searchPraticienById(){
    return this.http.get<Praticien[]>("http://localhost:8000/praticien/{id}", {observe: 'response'});
  }

  addPraticien(){
    return this.http.post<Praticien[]>("http://localhost:8000/praticiens", {observe: 'response'});
  }

}
