import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MowingComponent } from './mowing.component';

describe('MowingComponent', () => {
  let component: MowingComponent;
  let fixture: ComponentFixture<MowingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MowingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MowingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
