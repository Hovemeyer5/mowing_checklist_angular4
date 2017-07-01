import { Component, OnInit } from '@angular/core';

import { MowingPiece } from '../classes/mowingPiece';
import { MowingService } from '../services/mowing.service';


@Component({
  selector: 'app-mowing',
  templateUrl: './mowing.component.html',
  styleUrls: ['./mowing.component.css']
})
export class MowingComponent implements OnInit {
	mowingList: MowingPiece[] = [];
	today: Date;

	constructor(private mowingService: MowingService) { }

	ngOnInit() {
		this.today = new Date();
		this.mowingService.getMowingList(this.today)
			.then(mowingList => this.mowingList = mowingList);
	}

}
