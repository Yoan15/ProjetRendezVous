import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Rdv } from "../models/rdv.model";

@Injectable({providedIn: 'root'})
export class RdvService {
  listeRdvs: Rdv[];
  constructor (private http: HttpClient){

  }

  searchAllRdvs(){
    return this.http.get<Rdv[]>("http://localhost:8000/rdvs", {observe: 'response'});
  }

}
